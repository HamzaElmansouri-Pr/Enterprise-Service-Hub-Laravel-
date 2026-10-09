<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use LogsActivity, HasTranslations;

    public $translatable = ['title', 'meta_title', 'meta_description'];

    protected $attributes = [
        'is_active' => true,
    ];

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'is_active',
        'is_home'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_home' => 'boolean',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order_index');
    }
}
