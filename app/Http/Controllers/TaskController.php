<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(){
        $user = auth()->user();

        // Se for admin, pode ver todas as tarefas
        if ($user->is_admin) {
            $tasks = Task::orderBy('due_date', 'asc')->get();
        } else {
            $tasks = $user->tasks()->orderBy('due_date', 'asc')->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('tasks.create', compact('users'));
    }

    /**
     * Armazena uma nova tarefa no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pendente,em andamento,concluída',
            'due_date' => 'nullable|date',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        // Salvar a tarefa com o usuário criador
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'created_by' => auth()->id(), // Adicionando o ID do usuário logado
        ]);

        $task->users()->attach(auth()->id()); // Vincular o criador automaticamente

        if ($request->has('users')) {
            $task->users()->attach($request->users);
        }

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }


    /**
     * Exibe detalhes de uma tarefa específica.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Mostra o formulário de edição de uma tarefa.
     */
    public function edit(Task $task)
    {
        $users = User::where('id', '!=', $task->created_by)->get();
        return view('tasks.edit', compact('task', 'users'));
    }



    /**
     * Atualiza uma tarefa no banco de dados.
     */
    public function update(Request $request, Task $task){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pendente,em andamento,concluída',
            'due_date' => 'nullable|date',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        $task->update($request->only(['title', 'description', 'status', 'due_date']));

        if ($request->has('users')) {
            $task->users()->sync($request->users);
        }

        return redirect()->route('tasks.index')->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove uma tarefa do banco de dados.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tarefa deletada!');
    }
}
