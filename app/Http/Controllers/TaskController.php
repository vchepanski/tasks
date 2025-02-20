<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->is_admin ? Task::query() : $user->tasks();

        if ($request->has('status') && $request->status != 'todos') {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('due_date', 'asc')->get();
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
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'priority'      => 'required|in:baixa,media,alta',
            'due_date'      => 'date|after_or_equal:today',
            'status'        => 'required|in:pendente,em andamento,concluída',
            'users'         => 'array',
            'users.*'       => 'exists:users,id',
            'attachments'   => 'nullable|array',
            'attachments.*' => 'file|max:2048', // cada arquivo máximo 2MB
        ]);

        // Cria a tarefa com os dados recebidos
        $task = Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
            'status'      => $request->status,
            'created_by'  => auth()->id(),
        ]);

        // Vincula o criador automaticamente
        $task->users()->attach(auth()->id());

        // Vincula os demais usuários, se enviados
        if ($request->has('users')) {
            $task->users()->attach($request->users);
        }

        // Processa os anexos, se houver (vários arquivos)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                \App\Models\Attachment::create([
                    'task_id'       => $task->id,
                    'user_id'       => auth()->id(),
                    'file_path'     => $path,
                    'original_name' => $file->getClientOriginalName(), // Nome original do arquivo
                ]);
            }
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
