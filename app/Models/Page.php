<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
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
