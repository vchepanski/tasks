@extends('layouts.tasks')

@section('title', 'Criar Nova Tarefa')
@section('header', 'Criar Tarefa')

@section('content')
    <h2 class="mb-4 text-xl font-semibold">Nova Tarefa</h2>

    <form action="{{ route('tasks.store') }}" method="POST" class="p-6 bg-white rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium">Título</label>
            <input type="text" name="title" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Descrição</label>
            <textarea name="description" class="w-full p-2 border rounded"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Status</label>
            <select name="status" class="w-full p-2 border rounded">
                <option value="pendente">Pendente</option>
                <option value="em andamento">Em andamento</option>
                <option value="concluída">Concluída</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Data de Vencimento</label>
            <input type="date" name="due_date" class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600">Salvar</button>
    </form>
@endsection
