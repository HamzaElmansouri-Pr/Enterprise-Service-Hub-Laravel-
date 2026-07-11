<?php

declare(strict_types=1);

namespace App\Services\AI\Providers;

use App\Services\AI\AIProviderInterface;
use Illuminate\Support\Facades\Http;
use Exception;
use Generator;

class OpenAIProvider implements AIProviderInterface
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $defaultModel;

    public function __construct()
    {
        $this->apiKey = (string) config('ai.providers.openai.api_key');
        $this->baseUrl = (string) config('ai.providers.openai.base_url');
        $this->defaultModel = (string) config('ai.providers.openai.model');
    }

    public function complete(string $prompt, array $options = []): string
    {
        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/chat/completions", $this->buildPayload($prompt, $options, false));

        if ($response->failed()) {
            throw new Exception('OpenAI API Error: ' . $response->body());
        }

        $data = $response->json();

        return $data['choices'][0]['message']['content'] ?? '';
    }

    public function completeStream(string $prompt, array $options = []): Generator
    {
        $response = Http::withToken($this->apiKey)->withOptions([
            'stream' => true,
        ])->post("{$this->baseUrl}/chat/completions", $this->buildPayload($prompt, $options, true));

        if ($response->failed()) {
            throw new Exception('OpenAI API Stream Error: ' . $response->body());
        }

        $body = $response->toPsrResponse()->getBody();

        while (!$body->eof()) {
            $chunk = $body->read(1024);
            $lines = explode("\n", $chunk);
            foreach ($lines as $line) {
                if (str_starts_with($line, 'data: ')) {
                    $jsonData = substr($line, 6);
                    if (trim($jsonData) === '[DONE]') {
                        break 2;
                    }

                    $data = json_decode($jsonData, true);
                    if (isset($data['choices'][0]['delta']['content'])) {
                        yield $data['choices'][0]['delta']['content'];
                    }
                }
            }
        }
    }

    protected function buildPayload(string $prompt, array $options, bool $stream): array
    {
        return [
            'model' => $options['model'] ?? $this->defaultModel,
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => $options['temperature'] ?? config('ai.parameters.temperature'),
            'max_tokens' => $options['max_tokens'] ?? config('ai.parameters.max_tokens'),
            'stream' => $stream,
        ];
    }

    public function embed(string $text): array
    {
        $model = config('ai.providers.openai.embedding_model', 'text-embedding-3-small');

        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/embeddings", [
                'input' => $text,
                'model' => $model,
            ]);

        if ($response->failed()) {
            throw new Exception('OpenAI Embeddings API Error: ' . $response->body());
        }

        $data = $response->json();

        return $data['data'][0]['embedding'] ?? [];
    }

    public function generateStructured(string $prompt, array $schema, array $options = []): array
    {
        $payload = $this->buildPayload($prompt, $options, false);
        
        // Add JSON schema structure if provided
        if (!empty($schema)) {
            $payload['response_format'] = [
                'type' => 'json_schema',
                'json_schema' => [
                    'name' => 'response',
                    'schema' => $schema,
                    'strict' => true
                ]
            ];
        }

        $response = Http::withToken($this->apiKey)
            ->post("{$this->baseUrl}/chat/completions", $payload);

        if ($response->failed()) {
            throw new Exception('OpenAI API Error: ' . $response->body());
        }

        $data = $response->json();
        $content = $data['choices'][0]['message']['content'] ?? '{}';

        return json_decode($content, true) ?? [];
    }
}
