<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        $resetUrl = config('app.frontend_url') . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->getEmailForPasswordReset());

        return (new MailMessage)
            ->subject('Reset Password Request')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('We received a request to reset your password.')
            ->action('Reset Password', $resetUrl)
            ->line('This link will expire in 60 minutes.')
            ->line('If you didn\'t request a password reset, you can safely ignore this email.');
    }

}
