@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('{{ asset('img/atividades.avif') }}');">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg bg-opacity-90 backdrop-blur-md">
        <!-- Logo -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-blue-600">FlowTask 🚀</h1>
            <p class="text-gray-600">Crie sua conta e organize suas tarefas</p>
        </div>

        <!-- Formulário de Cadastro -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nome -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- E-mail -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Senha -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Senha -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Botão de Cadastro -->
            <button type="submit" class="w-full px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                Criar Conta
            </button>
        </form>

        <!-- Link para Login -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Já tem uma conta?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Entrar</a>
            </p>
        </div>
    </div>
</div>
@endsection
