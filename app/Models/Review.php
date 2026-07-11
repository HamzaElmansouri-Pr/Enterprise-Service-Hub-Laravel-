<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Review extends Model
{
    use LogsActivity, HasFactory, SoftDeletes, HasTranslations;

    public $translatable = ['client_name', 'client_position', 'review_text'];

    protected $attributes = [
        'is_active' => true,
    ];

    protected $fillable = [
        'client_name',
        'client_position',
        'client_company',
        'client_image',
        'review_text',
        'rating',
        'project_type',
        'is_featured',
        'is_active',
        'order_index',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'integer',
        'order_index' => 'integer',
    ];
}
