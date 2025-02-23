<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gerenciador de Tarefas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/js/messages.js'])
    <meta name="user-id" content="{{ auth()->check() ? auth()->id() : '' }}">
</head>
<body class="text-gray-900 bg-gray-100">

    @if(session('success'))
    <div id="success-message" class="fixed px-4 py-2 text-white transition-opacity duration-500 bg-green-500 rounded shadow-lg top-5 right-5">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="error-message" class="fixed px-4 py-2 text-white transition-opacity duration-500 bg-red-500 rounded shadow-lg top-5 right-5">
        {{ session('error') }}
    </div>
@endif

<nav class="fixed top-0 left-0 z-50 w-full text-white shadow-lg bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="flex items-center justify-between px-4 py-3 mx-auto max-w-7xl">
        <!-- Nome do Sistema -->
        <a href="{{ route('tasks.index') }}" class="text-2xl font-bold tracking-wide transition hover:scale-105">
            FlowTask 🚀
        </a>

        <!-- Links de Navegação -->
        <ul class="flex space-x-6">
            <li><a href="{{ route('tasks.index') }}" class="hover:underline">📋 Tarefas</a></li>
            <li><a href="{{ route('tasks.create') }}" class="hover:underline">➕ Nova Tarefa</a></li>
            <li><a href="{{ route('dashboard') }}" class="hover:underline">📊 Dashboard</a></li>
        </ul>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 transition bg-red-500 rounded-lg hover:bg-red-700">
                🚪 Sair
            </button>
        </form>
    </div>
</nav>


<div class="pt-16"> <!-- Adicionamos padding-top para evitar sobreposição -->
    <main class="max-w-4xl p-6 mx-auto mt-10 bg-white rounded-lg shadow">
        @yield('content')
    </main>
</div>

</body>
</html>
