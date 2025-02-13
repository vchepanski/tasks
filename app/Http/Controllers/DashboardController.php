<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $tasksQuery = $user->is_admin ? Task::query() : $user->tasks();

    return view('dashboard', [
        'pendingTasks' => $tasksQuery->where('status', 'pendente')->count(),
        'inProgressTasks' => $tasksQuery->where('status', 'em andamento')->count(),
        'completedTasks' => $tasksQuery->where('status', 'concluída')->count(),
    ]);
}

}
