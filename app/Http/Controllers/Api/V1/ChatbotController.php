<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatSession;
use App\Services\AI\AIService;
use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use App\Services\AI\PromptManager;
use App\Services\AI\RAGService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected AIService $ai;
    protected RAGService $rag;

    public function __construct(AIService $ai, RAGService $rag)
    {
        $this->ai = $ai;
        $this->rag = $rag;
    }

    /**
     * Handle the incoming chat message and stream the response.
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string|max:36',
        ]);

        $userMessage = $request->input('message');
        $sessionId = $request->input('session_id');

        // 1. Session Management
        if (!$sessionId) {
            $sessionId = (string) Str::uuid();
            $chatSession = ChatSession::create([
                'session_id' => $sessionId,
                'messages' => []
            ]);
        } else {
            $chatSession = ChatSession::where('session_id', $sessionId)->first();
            if (!$chatSession) {
                $chatSession = ChatSession::create([
                    'session_id' => $sessionId,
                    'messages' => []
                ]);
            }
        }

        // Add user message to session
        $messages = $chatSession->messages ?? [];
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        // 2. RAG Context Retrieval
        $context = $this->rag->retrieveContext($userMessage);

        // 3. Prompt Construction
        $prompt = $this->buildPrompt($messages, $context);

        // 4. Stream Response
        return response()->stream(function () use ($prompt, $chatSession, $messages) {
            try {
                $stream = $this->ai->stream($prompt, [
                    'max_tokens' => 1000,
                    'temperature' => 0.5,
                ]);

                $fullAiResponse = '';
                
                // Flush headers to start the SSE stream immediately
                ob_flush();
                flush();

                foreach ($stream as $chunk) {
                    $fullAiResponse .= $chunk;
                    echo "data: " . json_encode(['chunk' => $chunk, 'session_id' => $chatSession->session_id]) . "\n\n";
                    ob_flush();
                    flush();
                }

                // 5. Save the completed response to DB
                $messages[] = ['role' => 'assistant', 'content' => trim($fullAiResponse)];
                $chatSession->update(['messages' => $messages]);

                echo "data: [DONE]\n\n";
                ob_flush();
                flush();
            } catch (\Exception $e) {
                Log::error('Chatbot Stream Error: ' . $e->getMessage());
                $errorMsg = "I'm sorry, I am experiencing technical difficulties at the moment. Please try again later or use our contact form.";
                echo "data: " . json_encode(['error' => $errorMsg]) . "\n\n";
                echo "data: [DONE]\n\n";
                ob_flush();
                flush();
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no',
        ]);
    }


    /**
     * Build the full prompt including system instructions, context, and conversation history.
     */
    protected function buildPrompt(array $messages, string $context): string
    {
        $promptArray = PromptManager::renderWithRoles('chatbot', [
            'context' => $context,
            'messages' => array_slice($messages, -5)
        ]);
        
        return $promptArray['system'] . "\n\n" . $promptArray['user'];
    }
}
