<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostReacted extends Notification
{
    use Queueable;

    public $user;
    public $reaction;
    public $reactable;

    public function __construct($user, $reaction, $reactable)
    {
        $this->user = $user;
        $this->reaction = $reaction;
        $this->reactable = $reactable;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $type = class_basename($this->reactable); // Post أو Comment

        return [
            'message' => "{$this->user->name} عمل {$this->reaction} على {$type} بتاعك",
            'reactable_type' => $type,
            'reactable_id'   => $this->reactable->id,
            'user_id'        => $this->user->id,
        ];
    }
}
