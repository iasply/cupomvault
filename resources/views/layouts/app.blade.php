<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CupomVault')</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

<header class="bg-white border-b border-gray-200 py-4 px-8 flex justify-between items-center shadow-sm">
    <h1 class="text-xl font-semibold text-gray-800 tracking-wide">
        CupomVault
    </h1>

    <nav class="flex gap-6 text-gray-700 font-medium">
        <a href="{{ route('cupomvault.home') }}"
           class="hover:text-gray-900 transition">Início</a>

        <a href="{{ route('comercio.login') }}"
           class="hover:text-gray-900 transition">Comércios</a>

        <a href="{{ route('associado.login') }}"
           class="hover:text-gray-900 transition">Associados</a>
    </nav>
</header>

<main class="flex-1 w-full max-w-3xl mx-auto mt-10 mb-10 ">

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="text-center py-4 text-gray-600 text-sm bg-white border-t border-gray-200">
    &copy; {{ date('Y') }} CupomVault — Todos os direitos reservados.
</footer>

</body>
</html>
