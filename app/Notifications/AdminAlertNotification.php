<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AdminAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $category;
    protected string $title;
    protected string $message;
    protected ?string $actionUrl;
    protected ?string $icon;

    /**
     * Create a new notification instance.
     *
     * @param string $category  One of: contact, tc_request, comment, system
     * @param string $title     Short title for the notification
     * @param string $message   Descriptive message body
     * @param string|null $actionUrl  URL the notification should link to
     * @param string|null $icon  Font Awesome icon class
     */
    public function __construct(
        string $category,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?string $icon = null
    ) {
        $this->category  = $category;
        $this->title     = $title;
        $this->message   = $message;
        $this->actionUrl = $actionUrl;
        $this->icon      = $icon ?? $this->defaultIcon();
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation for the database.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'category'   => $this->category,
            'title'      => $this->title,
            'message'    => $this->message,
            'action_url' => $this->actionUrl,
            'icon'       => $this->icon,
        ];
    }

    /**
     * Get the broadcastable representation for Reverb / Echo.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id'         => $this->id,
            'category'   => $this->category,
            'title'      => $this->title,
            'message'    => $this->message,
            'action_url' => $this->actionUrl,
            'icon'       => $this->icon,
            'created_at' => now()->toISOString(),
        ]);
    }

    /**
     * Default icon per category.
     */
    private function defaultIcon(): string
    {
        return match ($this->category) {
            'contact'    => 'fas fa-envelope',
            'tc_request' => 'fas fa-file-alt',
            'comment'    => 'fas fa-comment',
            'system'     => 'fas fa-bell',
            default      => 'fas fa-bell',
        };
    }
}
