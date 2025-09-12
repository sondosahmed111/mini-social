<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostReacted extends Notification
{
    use Queueable;

    public $user;
    public $reaction;
    public $post;

    public function __construct($user, $reaction, $post)
    {
        $this->user = $user;
        $this->reaction = $reaction;
        $this->post = $post;
    }
    $targetUser->notify(new UserFollowed(auth()->user()));

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->user->name . " عمل {$this->reaction} على منشورك",
            'post_id' => $this->post->id,
            'user_id' => $this->user->id,
        ];

    }
}
