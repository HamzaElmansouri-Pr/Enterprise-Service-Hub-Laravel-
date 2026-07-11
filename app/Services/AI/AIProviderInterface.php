<?php

declare(strict_types=1);

namespace App\Services\AI;

use Generator;

interface AIProviderInterface
{
    /**
     * Get a synchronous completion for the given prompt.
     *
     * @param string $prompt
     * @param array $options Overrides for model, temperature, max_tokens, etc.
     * @return string
     */
    public function complete(string $prompt, array $options = []): string;

    /**
     * Get a streaming completion for the given prompt.
     * Yields chunks of text as they arrive from the provider.
     *
     * @param string $prompt
     * @param array $options Overrides for model, temperature, max_tokens, etc.
     * @return Generator
     */
    public function completeStream(string $prompt, array $options = []): Generator;

    /**
     * Generate vector embeddings for the given text.
     *
     * @param string $text
     * @return array<float>
     */
    public function embed(string $text): array;

    /**
     * Get a structured JSON completion based on a schema.
     *
     * @param string $prompt
     * @param array $schema The JSON schema definition
     * @param array $options
     * @return array
     */
    public function generateStructured(string $prompt, array $schema, array $options = []): array;
}
