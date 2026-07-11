<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AI\AIService;
use App\Services\AI\Providers\GeminiProvider;
use App\Services\AI\Providers\OpenAIProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Exception;

class AIServiceTest extends TestCase
{
    public function test_it_resolves_gemini_provider_by_default()
    {
        Config::set('ai.default', 'gemini');
        
        $service = app(AIService::class);
        $this->assertInstanceOf(AIService::class, $service);
        
        $reflection = new \ReflectionClass($service);
        $property = $reflection->getProperty('provider');
        $property->setAccessible(true);
        
        $this->assertInstanceOf(GeminiProvider::class, $property->getValue($service));
    }

    public function test_it_resolves_openai_provider_when_configured()
    {
        Config::set('ai.default', 'openai');
        
        $service = app(AIService::class);
        
        $reflection = new \ReflectionClass($service);
        $property = $reflection->getProperty('provider');
        $property->setAccessible(true);
        
        $this->assertInstanceOf(OpenAIProvider::class, $property->getValue($service));
    }

    public function test_gemini_provider_formats_request_correctly()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Gemini response text']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        Config::set('ai.default', 'gemini');
        Config::set('ai.providers.gemini.api_key', 'test-key');
        
        $service = app(AIService::class);
        $response = $service->generate('Hello Gemini');
        
        $this->assertEquals('Gemini response text', $response);
        
        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'test-key') &&
                   $request['contents'][0]['parts'][0]['text'] === 'Hello Gemini';
        });
    }

    public function test_openai_provider_formats_request_correctly()
    {
        Http::fake([
            'api.openai.com/*' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'OpenAI response text'
                        ]
                    ]
                ]
            ], 200)
        ]);

        Config::set('ai.default', 'openai');
        Config::set('ai.providers.openai.api_key', 'test-key');
        
        $service = app(AIService::class);
        $response = $service->generate('Hello OpenAI');
        
        $this->assertEquals('OpenAI response text', $response);
        
        Http::assertSent(function ($request) {
            return $request->hasHeader('Authorization', 'Bearer test-key') &&
                   $request['messages'][0]['content'] === 'Hello OpenAI';
        });
    }

    public function test_gemini_throws_exception_on_failure()
    {
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response('Server Error', 500)
        ]);

        Config::set('ai.default', 'gemini');
        
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Gemini API Error: Server Error');
        
        $service = app(AIService::class);
        $service->generate('Fail test');
    }

    public function test_openai_throws_exception_on_failure()
    {
        Http::fake([
            'api.openai.com/*' => Http::response('Server Error', 500)
        ]);

        Config::set('ai.default', 'openai');
        
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('OpenAI API Error: Server Error');
        
        $service = app(AIService::class);
        $service->generate('Fail test');
    }
}
