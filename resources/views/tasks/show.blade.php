@extends('layouts.tasks')

@section('title', 'Visualizar Tarefa')
@section('header', $task->title)

@section('content')
<div class="max-w-3xl p-8 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h2 class="mb-4 text-2xl font-bold text-gray-700">{{ $task->title }}</h2>
    <p class="mb-4 text-gray-600">{{ $task->description }}</p>

    <!-- Outras informações da tarefa, se necessário -->

    <!-- Seção de Anexos -->
    <div class="mt-6">
        <h3 class="mb-4 text-xl font-bold">Anexos</h3>
        <!-- Formulário para upload de anexo -->
        <form method="POST" action="{{ route('attachments.store', $task->id) }}" enctype="multipart/form-data" class="mb-4">
            @csrf
            <input type="file" name="attachment" class="mb-2" required>
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Enviar Anexo</button>
        </form>

        <!-- Lista de anexos -->
        <div>
            @forelse($task->attachments as $attachment)
                <div class="flex items-center justify-between mb-2">
                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                        Visualizar Anexo
                    </a>
                    <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este anexo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Remover</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-600">Nenhum anexo enviado ainda.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
