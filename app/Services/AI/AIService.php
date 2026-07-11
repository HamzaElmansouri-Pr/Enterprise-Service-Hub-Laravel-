<?php

declare(strict_types=1);

namespace App\Services\AI;

use Generator;

class AIService
{
    protected AIProviderInterface $provider;

    public function __construct(AIProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get a synchronous completion for the given prompt.
     *
     * @param string $prompt
     * @param array $options Overrides for model, temperature, max_tokens, etc.
     * @return string
     */
    public function generate(string $prompt, array $options = []): string
    {
        return $this->provider->complete($prompt, $options);
    }

    /**
     * Get a streaming completion for the given prompt.
     * Yields chunks of text as they arrive from the provider.
     *
     * @param string $prompt
     * @param array $options Overrides for model, temperature, max_tokens, etc.
     * @return Generator
     */
    public function stream(string $prompt, array $options = []): Generator
    {
        return $this->provider->completeStream($prompt, $options);
    }

    /**
     * Generate vector embeddings for the given text.
     *
     * @param string $text
     * @return array<float>
     */
    public function embed(string $text): array
    {
        return $this->provider->embed($text);
    }

    /**
     * Get a structured JSON completion based on a schema.
     *
     * @param string $prompt
     * @param array $schema The JSON schema definition
     * @param array $options
     * @return array
     */
    public function generateStructured(string $prompt, array $schema, array $options = []): array
    {
        return $this->provider->generateStructured($prompt, $schema, $options);
    }
}
