<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Blog;
use App\Models\Service;

class JsonLdService
{
    protected string $siteUrl;
    protected string $siteName;

    public function __construct()
    {
        $this->siteUrl = rtrim((string) config('app.frontend_url', config('app.url')), '/');
        $this->siteName = (string) config('app.name', 'Enterprise Service Hub');
    }

    /**
     * Generate Organization schema (for homepage).
     */
    public function organization(array $cmsData = []): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $this->siteName,
            'url' => $this->siteUrl,
        ];

        $heroImage = data_get($cmsData, 'heroImage');
        if (!empty($heroImage)) {
            $schema['logo'] = resolve_image_url($heroImage);
        }

        $description = data_get($cmsData, 'about.description');
        if (!empty($description)) {
            $schema['description'] = strip_tags($description);
        }

        return $schema;
    }

    /**
     * Generate WebSite schema with SearchAction (for homepage).
     */
    public function webSite(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $this->siteName,
            'url' => $this->siteUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => "{$this->siteUrl}/search?q={search_term_string}",
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Generate Article schema for a single blog post.
     */
    public function blogArticle(Blog $blog): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $blog->title,
            'url' => "{$this->siteUrl}/blog/{$blog->slug}",
            'datePublished' => $blog->published_at?->toIso8601String(),
            'dateModified' => $blog->updated_at?->toIso8601String(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => $this->siteName,
                'url' => $this->siteUrl,
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => "{$this->siteUrl}/blog/{$blog->slug}",
            ],
        ];

        if ($blog->image) {
            $schema['image'] = resolve_image_url($blog->image);
        }

        if ($blog->excerpt) {
            $schema['description'] = strip_tags($blog->excerpt);
        }

        if ($blog->relationLoaded('author') && $blog->author) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $blog->author->name,
            ];
        }

        if ($blog->category) {
            $schema['articleSection'] = $blog->category;
        }

        return $schema;
    }

    /**
     * Generate ItemList schema for blog listing page.
     */
    public function blogList($blogs): array
    {
        $items = [];
        $position = 1;

        foreach ($blogs as $blog) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'url' => "{$this->siteUrl}/blog/{$blog->slug}",
                'name' => $blog->title,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Blog Articles',
            'itemListElement' => $items,
        ];
    }

    /**
     * Generate Service schema for a single service.
     */
    public function service(Service $service): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service->title,
            'url' => "{$this->siteUrl}/services/{$service->slug}",
            'provider' => [
                '@type' => 'Organization',
                'name' => $this->siteName,
                'url' => $this->siteUrl,
            ],
        ];

        if ($service->subtitle) {
            $schema['alternateName'] = strip_tags($service->subtitle);
        }

        if ($service->description) {
            $schema['description'] = strip_tags($service->description);
        }

        if ($service->image) {
            $schema['image'] = resolve_image_url($service->image);
        }

        return $schema;
    }

    /**
     * Generate ItemList schema for the services listing page.
     */
    public function serviceList($services): array
    {
        $items = [];
        $position = 1;

        foreach ($services as $service) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'url' => "{$this->siteUrl}/services/{$service->slug}",
                'name' => $service->title,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'Our Services',
            'itemListElement' => $items,
        ];
    }

    /**
     * Generate BreadcrumbList schema.
     */
    public function breadcrumb(array $items): array
    {
        $listItems = [];
        $position = 1;

        foreach ($items as $name => $url) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
                'item' => $url,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }
}
