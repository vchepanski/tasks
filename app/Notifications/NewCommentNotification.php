<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewCommentNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $comment;
    public $task;

    public function __construct($task, $comment)
    {
        $this->task = $task;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'task_id'    => $this->task->id,
            'task_title' => $this->task->title,
            'comment'    => $this->comment->comment,
            'user'       => $this->comment->user->name,
            'message'    => 'Novo comentário na tarefa: "' . $this->task->title . '"',
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'task_id'    => $this->task->id,
            'task_title' => $this->task->title,
            'comment'    => $this->comment->comment,
            'user'       => $this->comment->user->name,
            'message'    => 'Novo comentário na tarefa: "' . $this->task->title . '"',
        ];
    }
}
