<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'client' => $this->client,
            'completion_date' => $this->completion_date?->toDateString(),
            'category' => $this->category ?? ($this->relationLoaded('categories') ? $this->categories->pluck('name')->implode(', ') : null),
            'categories' => $this->relationLoaded('categories')
                ? $this->categories->map(fn($cat) => [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                ])
                : [],
            'image' => resolve_image_url($this->image),
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured ?? false,
            'order_index' => $this->order_index,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'og_image' => resolve_image_url($this->og_image),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
