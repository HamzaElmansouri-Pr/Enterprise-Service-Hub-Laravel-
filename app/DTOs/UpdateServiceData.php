<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class UpdateServiceData
{
    public function __construct(
        public string|array $title,
        public ?string $slug = null,
        public string|array|null $subtitle = null,
        public string|array|null $description = null,
        public ?string $icon = null,
        public ?string $image = null,
        public ?int $order_index = null,
        public ?bool $is_active = null,
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
            subtitle: $data['subtitle'] ?? null,
            description: $data['description'] ?? null,
            icon: $data['icon'] ?? null,
            image: $data['image'] ?? null,
            order_index: isset($data['order_index']) ? (int) $data['order_index'] : null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
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
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'icon' => $this->icon,
            'image' => $this->image,
            'order_index' => $this->order_index,
            'is_active' => $this->is_active,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'og_image' => $this->og_image,
        ], fn ($v) => $v !== null);
    }
}
