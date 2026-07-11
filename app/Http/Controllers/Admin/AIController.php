<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AI\AIService;
use App\Services\AI\PromptManager;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AIController extends Controller
{
    protected AIService $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Generate content via AI streaming.
     */
    public function generateContent(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'context' => 'required|string',
            'tone' => 'nullable|string',
            'length' => 'nullable|string',
            'language' => 'nullable|string|in:en,fr,ar',
        ]);

        $type = $request->input('type');
        $context = $request->input('context');
        $tone = $request->input('tone', 'professional');
        $length = $request->input('length', 'medium');
        $language = $request->input('language', 'en');


        $langMap = ['en' => 'English', 'fr' => 'French', 'ar' => 'Arabic'];
        $lengthInstructions = [
            'short' => 'Keep the response short, around 100 words.',
            'medium' => 'Write a medium-length response, around 300 words.',
            'long' => 'Write a comprehensive and detailed response, around 600 words or more.',
        ];

        $promptData = [
            'type' => $type,
            'context' => $context,
            'tone' => $tone,
            'language' => $langMap[$language] ?? 'English',
            'lengthStr' => $lengthInstructions[$length] ?? $lengthInstructions['medium'],
        ];

        // Since it returns <system> and <user> we can combine them for now or just render
        $promptArray = PromptManager::renderWithRoles('content', $promptData);
        $prompt = $promptArray['system'] . "\n\n" . $promptArray['user'];
        
        $maxTokens = 1500;
        if ($length === 'short') {
            $maxTokens = 300;
        } elseif ($length === 'long') {
            $maxTokens = 2500;
        }

        return response()->stream(function () use ($prompt, $maxTokens) {
            $stream = $this->aiService->stream($prompt, ['max_tokens' => $maxTokens, 'temperature' => 0.7]);
            
            foreach ($stream as $chunk) {
                // We send SSE (Server-Sent Events) back to the client
                echo "data: " . json_encode(['chunk' => $chunk]) . "\n\n";
                ob_flush();
                flush();
            }
            
            echo "data: [DONE]\n\n";
            ob_flush();
            flush();
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Analyze content and generate SEO metadata.
     */
    public function analyzeSeo(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'title' => 'required|string',
        ]);

        $content = $request->input('content');
        $title = $request->input('title');

        // Prepare the prompt for the AI
        $promptArray = PromptManager::renderWithRoles('seo_meta', [
            'title' => $title,
            'content' => $content
        ]);
        $prompt = $promptArray['system'] . "\n\n" . $promptArray['user'];

        try {
            $schema = [
                'type' => 'OBJECT',
                'properties' => [
                    'meta_title' => ['type' => 'STRING', 'description' => 'A compelling SEO meta title, max 60 characters'],
                    'meta_description' => ['type' => 'STRING', 'description' => 'A compelling SEO meta description, max 160 characters'],
                    'og_title' => ['type' => 'STRING', 'description' => 'Social media OG title'],
                    'og_description' => ['type' => 'STRING', 'description' => 'Social media OG description'],
                    'focus_keywords' => ['type' => 'ARRAY', 'items' => ['type' => 'STRING']],
                    'seo_score' => ['type' => 'INTEGER', 'description' => 'Integer between 0 and 100 based on content quality and keyword presence'],
                    'readability_score' => ['type' => 'INTEGER', 'description' => 'Integer between 0 and 100'],
                    'suggestions' => ['type' => 'ARRAY', 'items' => ['type' => 'STRING']]
                ],
                'required' => ['meta_title', 'meta_description', 'og_title', 'og_description', 'focus_keywords', 'seo_score', 'readability_score', 'suggestions']
            ];

            $data = $this->aiService->generateStructured($prompt, $schema, ['temperature' => 0.4]);

            return response()->json($data);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('AI SEO Analysis failed: ' . $e->getMessage());
            return response()->json(['error' => 'AI generation failed.'], 500);
        }
    }

    /**
     * Conversational Admin Assistant Router
     */
    public function assistantRouter(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = $request->input('message');

        $promptArray = PromptManager::renderWithRoles('assistant_router', [
            'message' => $message
        ]);
        $prompt = $promptArray['system'] . "\n\n" . $promptArray['user'];

        try {
            $schema = [
                'type' => 'OBJECT',
                'properties' => [
                    'action' => ['type' => 'STRING', 'enum' => ['navigate', 'reply']],
                    'url' => ['type' => 'STRING', 'description' => 'populated if action is "navigate"'],
                    'message' => ['type' => 'STRING', 'description' => 'A friendly confirmation of what you are doing']
                ],
                'required' => ['action', 'message']
            ];

            $data = $this->aiService->generateStructured($prompt, $schema, ['temperature' => 0.2]);

            return response()->json($data);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('AI Assistant failed: ' . $e->getMessage());
            return response()->json([
                'action' => 'reply',
                'message' => 'I encountered an error trying to process your request.'
            ]);
        }
    }
}
