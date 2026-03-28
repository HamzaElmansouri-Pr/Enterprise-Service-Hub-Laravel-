<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'page_id',
        'name',
        'type',
        'order_index',
        'is_active',
        'settings'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function contentBlocks(): HasMany
    {
        return $this->hasMany(ContentBlock::class);
    }

    /**
     * Helper to get a specific content value by key
     */
    public function getContent(string $key, string $default = ''): string
    {
        // This is a naive implementation; in production we might eager load this differently
        $block = $this->contentBlocks->where('key', $key)->first();
        return (string) ($block ? $block->content : $default);
    }
}
