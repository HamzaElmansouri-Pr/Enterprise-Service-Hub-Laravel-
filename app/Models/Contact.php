<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Contact extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'company',
        'website',
        'is_read',
        'read_at',
        'replied_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    /**
     * Scope for unread contacts
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read contacts
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope for replied contacts
     */
    public function scopeReplied($query)
    {
        return $query->whereNotNull('replied_at');
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark as unread
     */
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
            'replied_at' => null, // Reset replied state as well if unread? Optional.
        ]);
    }

    /**
     * Mark as replied
     */
    public function markAsReplied()
    {
        $this->update([
            'is_read' => true,
            'read_at' => $this->read_at ?? now(),
            'replied_at' => now(),
        ]);
    }
}