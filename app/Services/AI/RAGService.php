<?php

declare(strict_types=1);

namespace App\Services\AI;

use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RAGService
{
    protected AIService $ai;
    protected float $relevanceThreshold;

    public function __construct(AIService $ai, float $relevanceThreshold = 0.6)
    {
        $this->ai = $ai;
        $this->relevanceThreshold = $relevanceThreshold;
    }

    /**
     * Retrieve and format context from the database using vector search.
     */
    public function retrieveContext(string $query): string
    {
        try {
            // Generate the query embedding
            $cacheKey = 'chatbot_embed_' . md5($query);
            $queryVector = Cache::remember($cacheKey, 3600, function () use ($query) {
                return $this->ai->embed($query);
            });

            if (empty($queryVector)) {
                return '';
            }

            // Perform hybrid search on each model via Meilisearch
            $services = Service::search($query, function ($meilisearch, $query, $options) use ($queryVector) {
                $options['vector'] = $queryVector;
                $options['hybrid'] = ['semanticRatio' => 0.8, 'embedder' => 'default'];
                $options['limit'] = 3;
                $options['showRankingScore'] = true;
                return $meilisearch->search($query, $options);
            })->raw();

            $projects = Project::search($query, function ($meilisearch, $query, $options) use ($queryVector) {
                $options['vector'] = $queryVector;
                $options['hybrid'] = ['semanticRatio' => 0.8, 'embedder' => 'default'];
                $options['limit'] = 2;
                $options['showRankingScore'] = true;
                return $meilisearch->search($query, $options);
            })->raw();

            $blogs = Blog::search($query, function ($meilisearch, $query, $options) use ($queryVector) {
                $options['vector'] = $queryVector;
                $options['hybrid'] = ['semanticRatio' => 0.8, 'embedder' => 'default'];
                $options['limit'] = 2;
                $options['showRankingScore'] = true;
                return $meilisearch->search($query, $options);
            })->raw();

            $contextText = "";

            $contextText .= $this->formatResults($services['hits'] ?? [], 'Service', ['title', 'subtitle', 'description']);
            $contextText .= $this->formatResults($projects['hits'] ?? [], 'Project', ['title', 'client', 'description']);
            $contextText .= $this->formatResults($blogs['hits'] ?? [], 'Blog Article', ['title', 'excerpt']);

            if (empty(trim($contextText))) {
                return "No highly relevant contextual information found.";
            }

            return "CONTEXT INFORMATION:\n" . $contextText;

        } catch (\Exception $e) {
            Log::error('Chatbot RAG Retrieval Error: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Format search hits, filter by relevance, and truncate long text.
     */
    protected function formatResults(array $hits, string $type, array $fields): string
    {
        $output = "";
        foreach ($hits as $hit) {
            // Apply relevance scoring cutoff
            $score = $hit['_rankingScore'] ?? 0;
            if ($score < $this->relevanceThreshold) {
                continue;
            }

            $output .= "- {$type}: ";
            foreach ($fields as $field) {
                if (!empty($hit[$field])) {
                    // Truncate long descriptions to save context window space
                    $value = strip_tags($hit[$field]);
                    $value = Str::limit($value, 300);
                    $output .= "{$value}. ";
                }
            }
            $output .= "(Relevance: " . round($score, 2) . ")\n";
        }
        return $output;
    }
}
