<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel')</title>

    @vite('resources/css/app.css')

    <style>
        body.fade-in {
            opacity: 0;
            transition: opacity .35s ease-in-out;
        }
        body.fade-in.loaded {
            opacity: 1;
        }
    </style>
</head>

<body class="fade-in bg-gray-100 text-gray-900 flex h-screen overflow-hidden">

<aside class="w-64 bg-gray-900 text-white flex flex-col fixed h-full shadow-xl">

    <div class="p-6 border-b border-gray-800">
        <h2 class="text-xl font-semibold leading-tight">
            {{ $usuarioNome }}
        </h2>

        <p class="text-sm text-gray-400 mt-1 leading-tight">
            {{ $usuarioEmail }}
        </p>
    </div>

    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">

        @foreach($menu as $item)
            <a href="{{ route($item['route']) }}"
               class="
                   flex items-center gap-2
                   py-2.5 px-3 rounded-lg text-sm font-medium transition-all
                   hover:bg-gray-800 hover:pl-4
                   {{ request()->routeIs($item['route']) ? 'bg-gray-800 pl-4' : '' }}
               ">
                <span class="text-lg">{!! $item['icon'] !!}</span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach

    </nav>

    <div class="p-5 border-t border-gray-800">
        <form action="{{ route($logoutRoute) }}" method="get">
            @csrf
            <button type="submit"
                    class="w-full py-2.5 bg-red-600 hover:bg-red-700 rounded-lg text-white font-semibold transition">
                Sair
            </button>
        </form>
    </div>
</aside>

<main class="flex-1 ml-64 overflow-y-auto p-10">

    {{-- Alertas --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-5 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-5 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-6xl mx-auto">
        @yield('content')
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const body = document.querySelector("body.fade-in");
        setTimeout(() => body.classList.add("loaded"), 50);
    });
</script>

</body>
</html>
