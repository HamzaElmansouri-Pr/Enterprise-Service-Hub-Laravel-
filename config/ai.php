<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default AI Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default AI provider that will be used by the
    | AIService. Supported values are 'gemini' and 'openai'.
    |
    */
    'default' => env('AI_PROVIDER', 'gemini'),

    /*
    |--------------------------------------------------------------------------
    | Provider Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure the settings for each AI provider, including
    | their API keys and default models.
    |
    */
    'providers' => [

        'gemini' => [
            'api_key' => env('GEMINI_API_KEY'),
            'model' => env('GEMINI_DEFAULT_MODEL', 'gemini-1.5-pro'),
            'embedding_model' => env('GEMINI_EMBEDDING_MODEL', 'text-embedding-004'),
            'embedding_dimension' => 768,
            'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
        ],

        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'model' => env('OPENAI_DEFAULT_MODEL', 'gpt-4o'),
            'embedding_model' => env('OPENAI_EMBEDDING_MODEL', 'text-embedding-3-small'),
            'embedding_dimension' => 1536,
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global Model Parameters
    |--------------------------------------------------------------------------
    |
    | Default parameters to use across all requests unless overridden.
    |
    */
    'parameters' => [
        'temperature' => (float) env('AI_TEMPERATURE', 0.7),
        'max_tokens' => (int) env('AI_MAX_TOKENS', 1500),
    ],

];
