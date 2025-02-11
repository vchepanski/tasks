<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gerenciador de Tarefas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-gray-900 bg-gray-100">

    <header class="py-4 text-white bg-blue-500">
        <div class="max-w-6xl px-4 mx-auto">
            <h1 class="text-2xl font-bold">@yield('header', 'Gerenciador de Tarefas')</h1>
        </div>
    </header>

    <main class="max-w-4xl p-6 mx-auto mt-10 bg-white rounded-lg shadow">
        @yield('content')
    </main>

</body>
</html>
