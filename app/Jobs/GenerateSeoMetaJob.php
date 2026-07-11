<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use App\Services\AI\AIService;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerateSeoMetaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Create a new job instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        
        // Push this job to the dedicated AI queue if you have one configured.
        $this->onQueue('ai');
    }

    /**
     * Execute the job.
     */
    public function handle(AIService $aiService): void
    {
        try {
            // Extract text content dynamically based on model attributes
            $title = $this->extractString($this->model->title);
            $content = $this->extractString($this->model->content ?? $this->model->description ?? '');
            
            // Clean HTML
            $content = strip_tags($content);
            $title = strip_tags($title);
            
            // Truncate content to avoid token limits for very large texts
            $content = substr($content, 0, 3000);

            $prompt = <<<EOT
You are an expert SEO copywriter. I will provide you with a title and content.
Write a compelling SEO meta description that is exactly between 120 and 155 characters long.
Do not include any quotes, markdown formatting, or HTML tags in your response. Just return the raw text.

Title: {$title}
Content: {$content}
EOT;

            $generatedDescription = trim($aiService->generate($prompt, ['max_tokens' => 100, 'temperature' => 0.7]));

            if (!empty($generatedDescription)) {
                // If model uses JSON translations for meta_description, handle it
                // Usually handled by Spatie Translatable or custom accessors/mutators.
                // We'll update the 'en' locale by default if it's translatable, 
                // or just the string if it's not.
                $currentMeta = $this->model->getRawOriginal('meta_description');
                
                if (is_string($currentMeta) && (str_starts_with($currentMeta, '{') || str_starts_with($currentMeta, '['))) {
                    $meta = json_decode($currentMeta, true) ?? [];
                    $meta['en'] = $generatedDescription;
                    $this->model->meta_description = $meta;
                } else {
                    $this->model->meta_description = $generatedDescription;
                }
                
                // Save without raising events to prevent loops
                $this->model->saveQuietly();
            }
        } catch (Throwable $e) {
            Log::error('GenerateSeoMetaJob failed: ' . $e->getMessage(), [
                'model' => get_class($this->model),
                'id' => $this->model->id
            ]);
            
            // We throw again so Laravel queues can handle retries if configured
            throw $e;
        }
    }
    
    /**
     * Helper to extract string from potentially translated array
     */
    protected function extractString($value): string
    {
        if (is_string($value)) {
            // It might be a JSON string from DB
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded['en'] ?? reset($decoded) ?? '';
            }
            return $value;
        }
        
        if (is_array($value)) {
            return $value['en'] ?? reset($value) ?? '';
        }
        
        return (string) $value;
    }
}
