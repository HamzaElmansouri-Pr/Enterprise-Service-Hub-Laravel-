<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'client_name' => $this->client_name,
            'client_position' => $this->client_position,
            'client_company' => $this->client_company,
            'client_image' => resolve_image_url($this->client_image),
            'review_text' => $this->review_text,
            'rating' => $this->rating,
            'project_type' => $this->project_type,
            'is_featured' => $this->is_featured,
            'order_index' => $this->order_index,
        ];
    }
}
