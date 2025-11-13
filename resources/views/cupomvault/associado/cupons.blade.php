@extends('layouts.associado')

@section('title', 'Meus Cupons')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-4 text-gray-800">🎟️ Meus Cupons</h1>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('associado.cupons') }}" class="mb-8 flex flex-col sm:flex-row gap-3">
        <input
            type="text"
            name="search"
            placeholder="Buscar por título ou comércio..."
            value="{{ request('search') }}"
            class="border border-gray-300 rounded-lg px-4 py-2 w-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
        >

        <select
            name="filtro"
            class="border border-gray-300 rounded-lg px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 transition"
        >
            <option value="">Todos</option>
             <option value="utilizado" {{ request('filtro') === 'utilizado' ? 'selected' : '' }}>Utilizados</option>
            <option value="vencido" {{ request('filtro') === 'vencido' ? 'selected' : '' }}>Vencidos</option>
        </select>

        <button
            type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition font-medium shadow-sm"
        >
            🔍 Buscar
        </button>
    </form>

    {{-- Lista de cupons --}}
    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse($cupons as $cupom)
        <x-cupom-card
            :cupom="$cupom"
            :acoes="[]"
        />
        @empty
        <p class="text-gray-500 text-center col-span-full py-6">
            Nenhum cupom encontrado.
        </p>
        @endforelse
    </div>

    {{-- Paginação --}}
    <div class="mt-8">
        {{ $cupons->withQueryString()->links() }}
    </div>
</div>
@endsection
