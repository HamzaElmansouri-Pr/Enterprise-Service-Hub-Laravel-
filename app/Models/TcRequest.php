<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class TcRequest extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'email',
        'service_id',
        'description',
        'attached_file',
        'budget_range',
        'timeline',
        'status',
        'admin_notes',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the service that owns the TC request
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Scope for unread requests
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for read requests
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope for requests by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
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
     * Update status
     */
    public function updateStatus($status, $notes = null)
    {
        $this->update([
            'status' => $status,
            'admin_notes' => $notes,
        ]);
    }
}