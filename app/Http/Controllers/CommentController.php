<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Comment;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        Comment::create([
            'task_id' => $task->id,
            'user_id' => FacadesAuth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comentário adicionado com sucesso!');
    }
}

