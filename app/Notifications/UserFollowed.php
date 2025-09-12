<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserFollowed extends Notification
{
    use Queueable;

    public $follower;

    public function __construct($follower)
    {
        $this->follower = $follower;
    }

    public function via($notifiable)
    {
        return ['database']; // نخزنها في الداتابيز
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->follower->name . ' بدأ بمتابعتك',
            'follower_id' => $this->follower->id,
        ];
    
    }
}
