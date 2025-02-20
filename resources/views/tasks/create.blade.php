@extends('layouts.app')

@section('title', 'Criar Nova Tarefa')

@section('content')
<div class="max-w-3xl p-8 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h2 class="mb-6 text-2xl font-bold text-gray-700">📌 Criar Nova Tarefa</h2>

    <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Título da Tarefa -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
            <input id="title" type="text" name="title" value="{{ old('title') }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('title')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Descrição -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Prioridade -->
        <div class="mb-4">
            <label for="priority" class="block text-sm font-medium text-gray-700">Prioridade</label>
            <select id="priority" name="priority" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="baixa" {{ old('priority') == 'baixa' ? 'selected' : '' }}>🔵 Baixa</option>
                <option value="media" {{ old('priority') == 'media' ? 'selected' : '' }}>🟠 Média</option>
                <option value="alta" {{ old('priority') == 'alta' ? 'selected' : '' }}>🔴 Alta</option>
            </select>
            @error('priority')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Data de Vencimento -->
        <div class="mb-4">
            <label for="due_date" class="block text-sm font-medium text-gray-700">Data de Vencimento</label>
            <input type="date" id="due_date" name="due_date"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('due_date')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status da Tarefa -->
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="pendente" {{ old('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="em andamento" {{ old('status') == 'em andamento' ? 'selected' : '' }}>Em Andamento</option>
                <option value="concluída" {{ old('status') == 'concluída' ? 'selected' : '' }}>Concluída</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Componente para Vincular Usuários -->
        <x-user-selector :users="$users" />

        <!-- Painel Colapsável para Anexos (com múltiplos inputs) -->
        <div x-data="{ files: [''] }" class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">Anexos</label>
            <template x-for="(file, index) in files" :key="index">
                <div class="mb-2">
                    <input type="file" :name="'attachments[]'" class="w-full">
                </div>
            </template>
            <button type="button" @click="files.push('')"
                    class="w-full px-4 py-2 text-white transition bg-gray-700 rounded-lg hover:bg-gray-800">
                Adicionar outro anexo
            </button>
        </div>

        <!-- Botão Criar -->
        <button type="submit" class="w-full px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
            Criar Tarefa 🚀
        </button>
    </form>
</div>
@endsection
