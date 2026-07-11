<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'badge_text' => $this->badge_text,
            'button_text' => $this->button_text,
            'button_url' => $this->button_url,
            'secondary_button_text' => $this->secondary_button_text,
            'secondary_button_url' => $this->secondary_button_url,
            'alignment' => $this->alignment,
            'overlay_opacity' => $this->overlay_opacity,
            'text_theme' => $this->text_theme,
            'video_url' => $this->video_url,
            'title_color' => $this->title_color,
            'subtitle_color' => $this->subtitle_color,
            'description_color' => $this->description_color,
            'image' => resolve_image_url($this->image),
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];
    }
}
