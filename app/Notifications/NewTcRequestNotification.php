<?php

namespace App\Notifications;

use App\Models\TcRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTcRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tcRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(TcRequest $tcRequest)
    {
        $this->tcRequest = $tcRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Technical Consultation Request')
            ->markdown('emails.tcrequest.new', ['tcRequest' => $this->tcRequest]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
