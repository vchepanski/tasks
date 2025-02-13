@extends('layouts.tasks')

@section('title', 'Tarefas - FlowTask')
@section('header', '📋 Minhas Tarefas')

@section('content')
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($tasks as $task)
            <div class="bg-white p-4 rounded-lg shadow-md border-l-4
                @if($task->status == 'pendente') border-blue-600
                @elseif($task->status == 'em andamento') border-yellow-500
                @else border-green-600 @endif
                hover:scale-105 transition">

                <h2 class="text-lg font-semibold">{{ $task->title }}</h2>
                <p class="text-sm text-gray-600">{{ $task->status }}</p>
                <p class="text-xs text-gray-500">Criado por: {{ $task->creator->name }}</p>

                <div class="flex justify-between mt-4">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:underline">✏️ Editar</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">🗑️ Excluir</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
