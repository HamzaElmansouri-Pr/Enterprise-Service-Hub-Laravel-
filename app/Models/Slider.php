<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use LogsActivity;

    use HasFactory, HasTranslations, SoftDeletes;

    public $translatable = ['title', 'subtitle', 'description', 'badge_text', 'button_text', 'secondary_button_text'];

    protected $attributes = [
        'is_active' => true,
    ];

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'badge_text',
        'button_text',
        'button_url',
        'secondary_button_text',
        'secondary_button_url',
        'alignment',
        'overlay_opacity',
        'text_theme',
        'video_url',
        'title_color',
        'subtitle_color',
        'description_color',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
