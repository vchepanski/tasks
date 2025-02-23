<!-- resources/views/components/comments.blade.php -->
<div class="p-4 rounded-lg shadow-md ajax-comments bg-gray-50" data-task-id="{{ $task->id }}">
    <h3 class="mb-4 text-xl font-semibold">Comentários</h3>

    <!-- Lista de Comentários -->
    <div id="comments-list-{{ $task->id }}">
        @foreach($comments as $comment)
            <div class="pb-2 mb-2 border-b border-gray-200 comment">
                <div class="flex items-center mb-1">
                    <div class="flex items-center justify-center w-8 h-8 mr-2 text-white bg-blue-500 rounded-full">
                        <!-- Você pode usar a inicial do usuário, por exemplo -->
                        <span class="text-sm font-bold">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                        <small class="ml-2 text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                <p class="text-gray-700">{{ $comment->comment }}</p>
            </div>
        @endforeach
    </div>

    <!-- Formulário para Adicionar Novo Comentário -->
    <form class="mt-4 comment-form" action="{{ route('comments.store', $task->id) }}" method="POST">
        @csrf
        <textarea name="comment" rows="3" placeholder="Escreva seu comentário..." required class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        <button type="submit" class="px-4 py-2 mt-2 text-white bg-blue-600 rounded hover:bg-blue-700">Enviar</button>
    </form>
</div>
