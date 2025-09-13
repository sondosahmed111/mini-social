<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostCommented extends Notification
{
    use Queueable;

    public $user;
    public $post;
    public $comment;

    public function __construct($user, $post, $comment)
    {
        $this->user = $user;
        $this->post = $post;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'       => 'comment',
            'user_name'  => $this->user->name,
            'post_id'    => $this->post->id,
            'post_title' => $this->post->title ?? null,
            'comment'    => $this->comment->body,
        ];
    }
}
