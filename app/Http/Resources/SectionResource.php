<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'page_id' => $this->page_id,
            'name' => $this->name,
            'type' => $this->type,
            'order_index' => $this->order_index,
            'is_active' => $this->is_active,
            'settings' => $this->settings,
        ];
    }
}
