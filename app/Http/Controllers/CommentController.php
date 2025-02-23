<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        // Valida o comentário
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Salva o comentário no banco de dados
        $comment = Comment::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        // Dispara a notificação para o criador da tarefa
        $task->creator->notify(new \App\Notifications\NewCommentNotification($task, $comment));

        // Opcional: Notifica outros usuários vinculados (exceto quem comentou)
        $task->users->each(function($user) use ($task, $comment) {
            if ($user->id !== $comment->user_id) {
                $user->notify(new \App\Notifications\NewCommentNotification($task, $comment));
            }
        });

        // Se a requisição for AJAX, retorna uma resposta JSON com os dados do comentário
        if ($request->ajax()) {
            return response()->json([
                'comment'   => $comment->comment,
                'user_name' => $comment->user->name,
            ]);
        }

        // Caso contrário, redireciona de volta com uma mensagem de sucesso
        return back()->with('success', 'Comentário adicionado com sucesso!');
    }
}

