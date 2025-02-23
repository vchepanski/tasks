<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TaskDueSoon extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    // Define os canais de entrega (salva no banco e transmite via broadcast)
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    // Dados para o canal de broadcast
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'task_id'   => $this->task->id,
            'title'     => $this->task->title,
            'due_date'  => $this->task->due_date,
            'message'   => 'A tarefa "' . $this->task->title . '" está próxima do vencimento!',
        ]);
    }

    // Dados para o armazenamento no banco de dados (opcional)
    public function toArray($notifiable)
    {
        return [
            'task_id'   => $this->task->id,
            'title'     => $this->task->title,
            'due_date'  => $this->task->due_date,
            'message'   => 'A tarefa "' . $this->task->title . '" está próxima do vencimento!',
        ];
    }
}
