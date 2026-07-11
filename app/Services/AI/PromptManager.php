<?php

declare(strict_types=1);

namespace App\Services\AI;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PromptManager
{
    /**
     * Render a prompt template with given variables.
     *
     * @param string $templateName Name of the template (e.g., 'content.blog_intro')
     * @param array $variables Variables to inject into the template
     * @return string
     */
    public static function render(string $templateName, array $variables = []): string
    {
        // Ensure the prompts namespace is registered
        if (!View::exists("prompts::{$templateName}")) {
            self::registerNamespace();
        }

        // Render the blade template
        $content = View::make("prompts::{$templateName}", $variables)->render();
        
        // Clean up excessive whitespace
        return self::cleanWhitespace($content);
    }
    
    /**
     * Parse system and user roles from a template if it contains special tags.
     * Useful for API providers that separate system instructions from user messages.
     * Example format in blade: 
     * <system>You are an expert.</system>
     * <user>Write a blog about {{ $topic }}.</user>
     * 
     * @param string $templateName
     * @param array $variables
     * @return array [ 'system' => '...', 'user' => '...' ]
     */
    public static function renderWithRoles(string $templateName, array $variables = []): array
    {
        $rendered = self::render($templateName, $variables);
        
        $system = '';
        $user = $rendered; // Default all to user if no tags
        
        if (preg_match('/<system>(.*?)<\/system>/s', $rendered, $matches)) {
            $system = self::cleanWhitespace($matches[1]);
            // Remove system block from user prompt
            $user = preg_replace('/<system>.*?<\/system>/s', '', $rendered);
        }
        
        if (preg_match('/<user>(.*?)<\/user>/s', $user, $matches)) {
            $user = self::cleanWhitespace($matches[1]);
        } else {
            $user = self::cleanWhitespace($user);
        }
        
        return [
            'system' => $system,
            'user' => $user
        ];
    }

    protected static function registerNamespace(): void
    {
        $promptsPath = resource_path('prompts');
        
        if (!File::exists($promptsPath)) {
            File::makeDirectory($promptsPath, 0755, true);
        }
        
        View::addNamespace('prompts', $promptsPath);
    }
    
    protected static function cleanWhitespace(string $content): string
    {
        // Remove multiple consecutive newlines but preserve single newlines
        $content = preg_replace("/[\r\n]{3,}/", "\n\n", $content);
        return trim($content);
    }
}
