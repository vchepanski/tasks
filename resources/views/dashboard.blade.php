@extends('layouts.tasks')

@section('title', 'Dashboard - FlowTask')
@section('header', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <!-- Estatísticas de Tarefas -->
        <div class="p-6 transition bg-white border-l-8 border-blue-600 rounded-lg shadow-md hover:scale-105">
            <h2 class="mb-4 text-lg font-semibold">📌 Tarefas Pendentes</h2>
            <p class="text-4xl font-bold text-blue-600">{{ $pendingTasks ?? 0 }}</p>
        </div>

        <div class="p-6 transition bg-white border-l-8 border-yellow-500 rounded-lg shadow-md hover:scale-105">
            <h2 class="mb-4 text-lg font-semibold">⚙️ Em Andamento</h2>
            <p class="text-4xl font-bold text-yellow-500">{{ $inProgressTasks ?? 0 }}</p>
        </div>

        <div class="p-6 transition bg-white border-l-8 border-green-600 rounded-lg shadow-md hover:scale-105">
            <h2 class="mb-4 text-lg font-semibold">✅ Concluídas</h2>
            <p class="text-4xl font-bold text-green-600">{{ $completedTasks ?? 0 }}</p>
        </div>
    </div>

    <!-- Atalhos Rápidos -->
    <div class="flex mt-6 space-x-4">
        <a href="{{ route('tasks.create') }}" class="px-4 py-2 text-white transition rounded-lg bg-gradient-to-r from-green-500 to-green-700 hover:scale-105">
            ➕ Nova Tarefa
        </a>
        <a href="{{ route('tasks.index') }}" class="px-4 py-2 text-white transition rounded-lg bg-gradient-to-r from-gray-500 to-gray-700 hover:scale-105">
            📋 Ver Tarefas
        </a>
    </div>
@endsection
