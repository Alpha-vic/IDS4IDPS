<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword {

    private $slug = 'resetpassword';

    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $views = ["emails.{$this->slug}", "emails.{$this->slug}-plain"];
        $data = ['notifiable' => $notifiable, 'slug' => $this->slug];

        return (new MailMessage)->view($views, $data)
                        ->greeting("Hello {$notifiable->first_name}")
                        ->line([
                            'You are receiving this email because we received a password reset request for your account.',
                            'Click the button below to reset your password:',
                        ])
                        ->action('Reset Password', route('auth.password.link', ['token'=>$this->token,'email'=>$notifiable->email]))
                        ->line('If you did not request a password reset, simply ignore this message.');
    }

}
