<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Welcome extends Notification {

    use Queueable;

    private $slug = 'welcome';
    private $isSeeding = false;

    /**
     * Create a new notification instance.
     */
    public function __construct($is_seeding = false)
    {
        $this->isSeeding = $is_seeding;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];
        if (!$this->isSeeding) {
            $via[] = 'mail';
        }
        return $via;
    }

    public function toDatabase($notifiable)
    {
        $title = "Welcome {$notifiable->first_name}! Quick read our community guide.";
        return [
            'message' => defaultNotificatonTemplate($title),
            'link' => rtrim(config('app.url'), '/') . '/guide'
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $views = ["emails.{$this->slug}", "emails.{$this->slug}-plain"];
        $data = ['slug' => $this->slug, 'notifiable' => $notifiable];

        return (new MailMessage)
            ->view($views, $data)
            ->subject("Welcome {$notifiable->first_name}");
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
