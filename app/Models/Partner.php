<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Partner extends Model
{
    use HasFactory, LogsActivity;

    protected $attributes = [
        'is_active' => true,
    ];

    protected $fillable = [
        'name',
        'logo',
        'url',
        'is_active',
        'order_index',
    ];

    /**
     * Get the full logo URL using the global helper.
     */
    public function getLogoUrl()
    {
        return resolve_image_url($this->logo);
    }
}
