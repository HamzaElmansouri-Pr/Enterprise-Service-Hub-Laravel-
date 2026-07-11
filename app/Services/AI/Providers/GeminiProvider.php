<?php

declare(strict_types=1);

namespace App\Services\AI\Providers;

use App\Services\AI\AIProviderInterface;
use Illuminate\Support\Facades\Http;
use Exception;
use Generator;

class GeminiProvider implements AIProviderInterface
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $defaultModel;

    public function __construct()
    {
        $this->apiKey = (string) config('ai.providers.gemini.api_key');
        $this->baseUrl = (string) config('ai.providers.gemini.base_url');
        $this->defaultModel = (string) config('ai.providers.gemini.model');
    }

    public function complete(string $prompt, array $options = []): string
    {
        $model = $options['model'] ?? $this->defaultModel;
        $url = "{$this->baseUrl}/models/{$model}:generateContent?key={$this->apiKey}";

        $response = Http::post($url, $this->buildPayload($prompt, $options));

        if ($response->failed()) {
            throw new Exception('Gemini API Error: ' . $response->body());
        }

        $data = $response->json();
        
        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    public function completeStream(string $prompt, array $options = []): Generator
    {
        $model = $options['model'] ?? $this->defaultModel;
        $url = "{$this->baseUrl}/models/{$model}:streamGenerateContent?key={$this->apiKey}&alt=sse";

        $response = Http::withOptions([
            'stream' => true,
        ])->post($url, $this->buildPayload($prompt, $options));

        if ($response->failed()) {
            throw new Exception('Gemini API Stream Error: ' . $response->body());
        }

        $body = $response->toPsrResponse()->getBody();

        while (!$body->eof()) {
            $chunk = $body->read(1024);
            // Parse SSE chunk
            $lines = explode("\n", $chunk);
            foreach ($lines as $line) {
                if (str_starts_with($line, 'data: ')) {
                    $jsonData = substr($line, 6);
                    if (trim($jsonData) === '[DONE]') {
                        break 2;
                    }

                    $data = json_decode($jsonData, true);
                    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                        yield $data['candidates'][0]['content']['parts'][0]['text'];
                    }
                }
            }
        }
    }

    protected function buildPayload(string $prompt, array $options): array
    {
        $parts = [];

        // If there's an image provided, it should go before the text prompt
        if (isset($options['image']) && isset($options['mime_type'])) {
            $parts[] = [
                'inlineData' => [
                    'mimeType' => $options['mime_type'],
                    'data' => $options['image']
                ]
            ];
        }

        $parts[] = ['text' => $prompt];

        $generationConfig = [
            'temperature' => (float) ($options['temperature'] ?? config('ai.parameters.temperature', 0.7)),
            'maxOutputTokens' => (int) ($options['max_tokens'] ?? config('ai.parameters.max_tokens', 1500)),
        ];

        if (isset($options['responseSchema'])) {
            $generationConfig['responseMimeType'] = 'application/json';
            $generationConfig['responseSchema'] = $options['responseSchema'];
        }

        return [
            'contents' => [
                [
                    'parts' => $parts
                ]
            ],
            'generationConfig' => $generationConfig
        ];
    }

    public function embed(string $text): array
    {
        $model = config('ai.providers.gemini.embedding_model', 'text-embedding-004');
        $url = "{$this->baseUrl}/models/{$model}:embedContent?key={$this->apiKey}";

        $response = Http::post($url, [
            'model' => "models/{$model}",
            'content' => [
                'parts' => [
                    ['text' => $text]
                ]
            ]
        ]);

        if ($response->failed()) {
            throw new Exception('Gemini Embeddings API Error: ' . $response->body());
        }

        $data = $response->json();

        return $data['embedding']['values'] ?? [];
    }

    public function generateStructured(string $prompt, array $schema, array $options = []): array
    {
        $options['responseSchema'] = $schema;
        
        $jsonString = $this->complete($prompt, $options);
        
        $data = json_decode($jsonString, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Failed to decode structured JSON from AI response: ' . json_last_error_msg());
        }
        
        return $data;
    }
}
