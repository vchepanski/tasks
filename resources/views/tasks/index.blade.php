@extends('layouts.tasks')

@section('title', 'Lista de Tarefas')
@section('header', 'Minhas Tarefas')

@section('content')
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Lista de Tarefas</h2>
        <a href="{{ route('tasks.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Nova Tarefa</a>
    </div>

    @if($tasks->isEmpty())
        <p class="text-center text-gray-500">Nenhuma tarefa encontrada.</p>
    @else
        <ul class="space-y-4">
            @foreach($tasks as $task)
                <li class="flex items-center justify-between p-4 border rounded-lg bg-gray-50">
                    <div>
                        <strong class="text-lg">{{ $task->title }}</strong>
                        <p class="text-sm text-gray-600">{{ $task->status }}</p>
                    </div>
                    <div>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="mr-2 text-blue-500 hover:underline">Editar</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
