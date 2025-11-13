<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel do Associado')</title>
    @vite('resources/css/app.css') {{-- Tailwind --}}
</head>

<body class="bg-gray-100 text-gray-900 flex h-screen overflow-hidden">

{{-- Sidebar fixa tipo ChatGPT --}}
<aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full transition-all duration-300">
    <div class="p-5 border-b border-gray-800">
        <h2 class="text-lg font-semibold truncate">
            {{ session('associado')->nom_associado ?? 'Associado' }}
        </h2>
        <p class="text-sm text-gray-400 truncate">
            {{ session('associado')->email_associado ?? '' }}
        </p>
    </div>

    {{-- Navegação --}}
    <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
        <a href="{{ route('associado.home') }}"
           class="block py-2 px-3 rounded hover:bg-gray-800 transition {{ request()->routeIs('comercio.home') ? 'bg-gray-800' : '' }}">
            🏠 Início
        </a>
        <a href="{{ route('associado.cupons') }}"
           class="block py-2 px-3 rounded hover:bg-gray-800 transition {{ request()->routeIs('comercio.cupons') ? 'bg-gray-800' : '' }}">
            🎟️ Meus Cupons
        </a>
{{--        <a href="{{ route('associado.perfil') }}"--}}
{{--           class="block py-2 px-3 rounded hover:bg-gray-800 transition {{ request()->routeIs('comercio.perfil') ? 'bg-gray-800' : '' }}">--}}
{{--            👤 Meu Perfil--}}
{{--        </a>--}}
    </nav>

    {{-- Rodapé da barra lateral --}}
    <div class="p-4 border-t border-gray-800">
        <form action="{{ route('comercio.logout') }}" method="get">
            @csrf
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-2 rounded text-white">
                Sair
            </button>
        </form>
    </div>
</aside>

{{-- Conteúdo principal --}}
<main class="flex-1 ml-64 overflow-y-auto p-8 transition-all duration-300">
    {{-- Mensagens Globais --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Conteúdo da página --}}
    @yield('content')
</main>

{{-- Pequeno script opcional para animações de troca de página --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.body.classList.add("opacity-0");
        setTimeout(() => document.body.classList.remove("opacity-0"), 100);
    });
</script>

</body>
</html>
