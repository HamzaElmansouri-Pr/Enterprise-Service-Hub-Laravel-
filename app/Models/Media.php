<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'mime_type',
        'disk',
        'size',
        'url',
        'alt_text',
    ];
}
