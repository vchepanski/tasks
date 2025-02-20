<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Se for admin, pega todas as tarefas; caso contrário, apenas as vinculadas ao usuário
        $tasksQuery = $user->is_admin ? Task::query() : $user->tasks();

        // Clone o builder para cada contagem
        $pendingTasks    = (clone $tasksQuery)->where('status', 'pendente')->count();
        $inProgressTasks = (clone $tasksQuery)->where('status', 'em andamento')->count();
        $completedTasks  = (clone $tasksQuery)->where('status', 'concluída')->count();

        return view('dashboard', compact('pendingTasks', 'inProgressTasks', 'completedTasks'));
    }


}
