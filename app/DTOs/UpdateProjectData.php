<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class UpdateProjectData
{
    public function __construct(
        public string|array $title,
        public ?string $slug = null,
        public string|array|null $description = null,
        public ?string $client = null,
        public ?string $completion_date = null,
        public ?string $category = null,
        public ?string $image = null,
        public ?bool $is_active = null,
        public ?int $order_index = null,
        public string|array|null $meta_title = null,
        public string|array|null $meta_description = null,
        public ?string $og_image = null,
    ) {}

    /**
     * Create from validated request array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            slug: $data['slug'] ?? null,
            description: $data['description'] ?? null,
            client: $data['client'] ?? null,
            completion_date: $data['completion_date'] ?? null,
            category: $data['category'] ?? null,
            image: $data['image'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            order_index: isset($data['order_index']) ? (int) $data['order_index'] : null,
            meta_title: $data['meta_title'] ?? null,
            meta_description: $data['meta_description'] ?? null,
            og_image: $data['og_image'] ?? null,
        );
    }

    /**
     * Convert to array for Eloquent mass-assignment.
     * Keeps null values out so unchanged fields aren't overwritten.
     */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'client' => $this->client,
            'completion_date' => $this->completion_date,
            'category' => $this->category,
            'image' => $this->image,
            'is_active' => $this->is_active,
            'order_index' => $this->order_index,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'og_image' => $this->og_image,
        ], fn ($v) => $v !== null);
    }
}
