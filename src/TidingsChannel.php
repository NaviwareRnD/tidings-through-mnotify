<?php

namespace Naviware\Tidings;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TidingsChannel
{
    use Queueable;

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        //get instance of user or notifiable
        //toTidings() returns an instance of TidingsMessage class
        $message = $notification->toTidings($notifiable);

        dd($message);

        // Send notification to the $notifiable instance...
        $message->send();
    }
}
