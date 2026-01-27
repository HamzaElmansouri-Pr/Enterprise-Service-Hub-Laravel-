<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentBlock extends Model
{
    protected $fillable = [
        'section_id',
        'key',
        'content',
        'type'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
