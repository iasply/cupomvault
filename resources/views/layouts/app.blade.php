<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'CupomVault')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

<header class="bg-white border-b border-gray-200 py-4 px-6 flex justify-between items-center shadow-sm relative">
    <h1 class="text-xl font-semibold text-gray-800 tracking-wide">
        CupomVault
    </h1>

    <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <nav id="menu"
         class="hidden md:flex gap-6 text-gray-700 font-medium flex-col md:flex-row absolute md:static top-full left-0 w-full md:w-auto bg-white md:bg-transparent shadow-md md:shadow-none p-4 md:p-0 z-10">
        <a href="{{ route('cupomvault.home') }}" class="hover:text-gray-900 transition block md:inline-block">Início</a>
        <a href="{{ route('comercio.login') }}"
           class="hover:text-gray-900 transition block md:inline-block">Comércios</a>
        <a href="{{ route('associado.login') }}"
           class="hover:text-gray-900 transition block md:inline-block">Associados</a>
    </nav>
</header>

<main class="flex-1 w-full max-w-3xl mx-auto mt-10 mb-10 px-4">

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

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
            @foreach($errors->all() as $erro)
                <p>{{ $erro }}</p>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>

<footer class="text-center py-4 text-gray-600 text-sm bg-white border-t border-gray-200">
    &copy; {{ date('Y') }} CupomVault — Todos os direitos reservados.
</footer>

<script>
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');

    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target) && !btn.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>

</body>
</html>
