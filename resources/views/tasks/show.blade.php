@extends('layouts.tasks')

@section('title', 'Visualizar Tarefa')
@section('header', $task->title)

@section('content')
<div class="max-w-4xl mx-auto mt-10 space-y-8">
    <!-- Seção de Detalhes da Tarefa -->
    <div class="p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-gray-800">{{ $task->title }}</h2>
        <p class="mt-4 text-gray-600">{{ $task->description }}</p>
    </div>

    <!-- Seção de Usuários Vinculados -->
    <div class="p-8 bg-white rounded-lg shadow-lg">
        <h3 class="mb-4 text-2xl font-bold text-gray-800">Usuários Vinculados</h3>
        <p><strong>Criador:</strong> {{ $task->creator->name ?? 'N/A' }}</p>
        @php
            // Filtra os usuários vinculados, excluindo o criador
            $otherUsers = $task->users->reject(function($user) use ($task) {
                return $user->id == $task->created_by;
            });
        @endphp
        @if($otherUsers->isNotEmpty())
            <p class="mt-2"><strong>Outros Usuários:</strong></p>
            <ul class="pl-5 list-disc">
                @foreach($otherUsers as $user)
                    <li>{{ $user->name }}</li>
                @endforeach
            </ul>
        @else
            <p class="mt-2 text-gray-600">Nenhum outro usuário vinculado.</p>
        @endif
    </div>

    <!-- Seção de Anexos -->
    <div class="p-8 bg-white rounded-lg shadow-lg">
        <h3 class="mb-4 text-2xl font-bold text-gray-800">Anexos</h3>
        <!-- Formulário para upload de anexo(s) -->
        <form method="POST" action="{{ route('attachments.store', $task->id) }}" enctype="multipart/form-data" class="mb-6">
            @csrf
            <input type="file" name="attachments[]" multiple class="block mb-2">
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                Enviar Anexo(s)
            </button>
        </form>

        <!-- Lista de anexos -->
        <div class="grid grid-cols-1 gap-4">
            @forelse($task->attachments as $attachment)
                <div class="flex items-center justify-between p-4 rounded shadow bg-gray-50">
                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $attachment->original_name ?? 'Visualizar Anexo' }}
                    </a>
                    <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este anexo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">
                            Remover
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-600">Nenhum anexo enviado ainda.</p>
            @endforelse
        </div>
    </div>

    <!-- Seção de Comentários -->
    <div class="p-8 bg-white rounded-lg shadow-lg">
        <h3 class="mb-4 text-2xl font-bold text-gray-800">Comentários</h3>
        <!-- Formulário para Adicionar Comentário -->
        <form method="POST" action="{{ route('comments.store', $task->id) }}" class="mb-6">
            @csrf
            <textarea name="comment" rows="3" class="w-full p-2 border rounded" placeholder="Adicione um comentário..." required></textarea>
            <button type="submit" class="px-4 py-2 mt-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                Enviar Comentário
            </button>
        </form>

        <!-- Lista de Comentários -->
        <div>
            @forelse($task->comments as $comment)
                <div class="p-4 mb-4 border rounded">
                    <p class="text-gray-700">{{ $comment->comment }}</p>
                    <small class="text-gray-500">
                        Por {{ $comment->user->name }} em {{ $comment->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            @empty
                <p class="text-gray-600">Nenhum comentário adicionado ainda.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
