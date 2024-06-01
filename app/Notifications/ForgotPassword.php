<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForgotPassword extends Notification
{
    use Queueable;
    protected $token;
    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $data)
    {
        $this->token = $token;
        $this->data = $data;
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
        ->subject('Reset Password Notification')
        ->greeting('Hello ' . $this->data->name . ',')
        ->line('You are receiving this email because we received a password reset request for your account.')
        ->action('Reset Password', route('auth.resetPasswordForm', $this->token))
        ->line('If you did not request a password reset, no further action is required.')
        ->line('Thank you, have a nice day!');
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
