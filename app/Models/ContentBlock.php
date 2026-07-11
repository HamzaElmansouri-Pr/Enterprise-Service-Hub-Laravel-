<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ContentBlock extends Model
{
    use LogsActivity;

    use HasTranslations;

    public $translatable = ['content'];

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
