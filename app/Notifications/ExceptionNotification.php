<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExceptionNotification extends Notification
{
    use Queueable;

    public $exception;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Exception Occurred')
                    ->line('An exception has occurred in your application.')
                    ->line('Exception Message: ' . $this->exception->getMessage())
                    ->line('File: ' . $this->exception->getFile())
                    ->line('Line: ' . $this->exception->getLine())
                    ->line('Stack Trace: ' . $this->exception->getTraceAsString());
    }
}
