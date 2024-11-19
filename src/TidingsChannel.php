<?php

namespace Naviware\Tidings;

//use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TidingsChannel
{

    
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send(mixed $notifiable, Notification $notification): void
    {
        //get instance of user or notifiable
        //toTidings() returns an instance of TidingsMessage class
        $message = $notification->toTidings($notifiable);

//        dd($message);

        // Send notification to the $notifiable instance...
        $message->send();
    }
}
