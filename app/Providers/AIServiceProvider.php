<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\AI\AIProviderInterface;
use App\Services\AI\AIService;
use App\Services\AI\Providers\GeminiProvider;
use App\Services\AI\Providers\OpenAIProvider;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AIProviderInterface::class, function ($app) {
            $provider = config('ai.default');

            return match ($provider) {
                'gemini' => new GeminiProvider(),
                'openai' => new OpenAIProvider(),
                default => throw new InvalidArgumentException("Unsupported AI provider: {$provider}"),
            };
        });

        $this->app->singleton(AIService::class, function ($app) {
            return new AIService($app->make(AIProviderInterface::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
