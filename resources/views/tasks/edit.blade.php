@extends('layouts.tasks')

@section('title', 'Editar Tarefa')
@section('header', 'Editar Tarefa')

@section('content')
    <h2 class="mb-4 text-xl font-semibold">Editar Tarefa</h2>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="p-6 bg-white rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium">Título</label>
            <input type="text" name="title" value="{{ $task->title }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Descrição</label>
            <textarea name="description" class="w-full p-2 border rounded">{{ $task->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Status</label>
            <select name="status" class="w-full p-2 border rounded">
                <option value="pendente" {{ $task->status == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="em andamento" {{ $task->status == 'em andamento' ? 'selected' : '' }}>Em andamento</option>
                <option value="concluída" {{ $task->status == 'concluída' ? 'selected' : '' }}>Concluída</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Data de Vencimento</label>
            <input type="date" name="due_date" value="{{ $task->due_date }}" class="w-full p-2 border rounded">
        </div>

        <x-user-selector :users="$users" :selectedUsers="$task->users->pluck('id')->toArray()" />

        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Atualizar</button>
    </form>
@endsection
