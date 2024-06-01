<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPassword extends Notification
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->greeting('Hello ' . $this->data->name . ',')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', route('adminAuth.newPasswordForm', $this->token))
            ->line('If you did not request a password reset, no further action is required.')
            ->line('Thank you, have a nice day!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
