@extends('layouts.tasks')

@section('title', 'Editar Tarefa')
@section('header', 'Editar Tarefa')

@section('content')
<div class="max-w-3xl p-8 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h2 class="mb-6 text-2xl font-bold text-gray-700">📌 Editar Tarefa</h2>

    <!-- Formulário de Edição da Tarefa -->
    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="p-6 bg-white rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
            <input id="title" type="text" name="title" value="{{ old('title', $task->title) }}" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('title')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Descrição -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $task->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Prioridade -->
        <div class="mb-4">
            <label for="priority" class="block text-sm font-medium text-gray-700">Prioridade</label>
            <select id="priority" name="priority" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="baixa" {{ old('priority', $task->priority) == 'baixa' ? 'selected' : '' }}>🔵 Baixa</option>
                <option value="media" {{ old('priority', $task->priority) == 'media' ? 'selected' : '' }}>🟠 Média</option>
                <option value="alta" {{ old('priority', $task->priority) == 'alta' ? 'selected' : '' }}>🔴 Alta</option>
            </select>
            @error('priority')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Data de Vencimento -->
        <div class="mb-4">
            <label for="due_date" class="block text-sm font-medium text-gray-700">Data de Vencimento</label>
            <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date) }}"
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
                <option value="pendente" {{ old('status', $task->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="em andamento" {{ old('status', $task->status) == 'em andamento' ? 'selected' : '' }}>Em Andamento</option>
                <option value="concluída" {{ old('status', $task->status) == 'concluída' ? 'selected' : '' }}>Concluída</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Componente para Vincular Usuários -->
        <x-user-selector :users="$users" :selectedUsers="$task->users->pluck('id')->toArray()" />

        <!-- Botão Atualizar Tarefa -->
        <button type="submit" class="w-full px-4 py-2 mt-4 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
            Atualizar 🚀
        </button>
    </form>

    <!-- Painel Colapsável de Anexos -->
    <div x-data="{ openAttachments: false, files: [''] }" class="mt-8">
        <button @click="openAttachments = !openAttachments" class="w-full px-4 py-2 text-white transition bg-gray-700 rounded-lg hover:bg-gray-800">
            <span x-text="openAttachments ? 'Ocultar Anexos' : 'Mostrar Anexos'"></span>
        </button>

        <div x-show="openAttachments" class="mt-4">
            <!-- Formulário para Upload de Novo(s) Anexo(s) -->
            <form method="POST" action="{{ route('attachments.store', $task->id) }}" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div x-data="{ files: [''] }">
                    <template x-for="(file, index) in files" :key="index">
                        <div class="mb-2">
                            <input type="file" :name="'attachments[]'" class="w-full">
                        </div>
                    </template>
                    <button type="button" @click="files.push('')" class="w-full px-4 py-2 text-white transition bg-gray-700 rounded-lg hover:bg-gray-800">
                        Adicionar outro anexo
                    </button>
                </div>
                <button type="submit" class="w-full px-4 py-2 mt-4 text-white bg-blue-600 rounded hover:bg-blue-700">
                    Enviar Anexo(s)
                </button>
            </form>

            <!-- Lista de Anexos -->
            <div>
                @forelse($task->attachments as $attachment)
                    <div class="flex items-center justify-between p-4 mb-2 border rounded">
                        <span class="font-medium text-gray-800">{{ $attachment->original_name }}</span>
                        <div class="flex items-center space-x-4">
                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                Visualizar
                            </a>
                            <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este anexo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Remover</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">Nenhum anexo enviado ainda.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Painel Colapsável de Comentários (opcional) -->
    <div x-data="{ openComments: false }" class="mt-8">
        <button @click="openComments = !openComments" class="w-full px-4 py-2 text-white transition bg-gray-700 rounded-lg hover:bg-gray-800">
            <span x-text="openComments ? 'Ocultar Comentários' : 'Mostrar Comentários'"></span>
        </button>

        <div x-show="openComments" class="mt-4">
            <!-- Formulário para Adicionar Comentário -->
            <form method="POST" action="{{ route('comments.store', $task->id) }}" class="mb-4">
                @csrf
                <textarea name="comment" rows="3" class="w-full p-2 border rounded" placeholder="Adicione um comentário..." required></textarea>
                <button type="submit" class="px-4 py-2 mt-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    Enviar Comentário
                </button>
            </form>

            <!-- Lista de Comentários -->
            <div>
                @forelse($task->comments as $comment)
                    <div class="p-4 mb-2 border rounded">
                        <p class="text-gray-700">{{ $comment->comment }}</p>
                        <small class="text-gray-500">Por {{ $comment->user->name }} em {{ $comment->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                @empty
                    <p class="text-gray-600">Nenhum comentário adicionado ainda.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
