@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-center bg-cover" style="background-image: url('{{ asset('img/atividades.avif') }}');">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg bg-opacity-90 backdrop-blur-md">
        <!-- Logo -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-blue-600">FlowTask 🚀</h1>
            <p class="text-gray-600">Gerencie suas tarefas de forma eficiente</p>
        </div>

        <!-- Formulário de Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- E-mail -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
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

            <!-- Lembrar-me -->
            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 form-checkbox">
                    <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Esqueceu a senha?</a>
            </div>

            <!-- Botão de Login -->
            <button type="submit" class="w-full px-4 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                Entrar
            </button>
        </form>

        <!-- Link para Cadastro -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">Ainda não tem uma conta?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Cadastre-se</a>
            </p>
        </div>
    </div>
</div>
@endsection
