@extends('layouts.associado')

@section('title', 'Home do Associado')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">🎟️ Bem-vindo!</h1>
        <p class="text-gray-600 mb-8">
            Aqui você pode buscar por novos cupons ou ativar os disponíveis.
        </p>

        {{-- Formulário de busca --}}
        <form method="GET" action="{{ route('associado.home') }}" class="mb-8 flex flex-col sm:flex-row gap-3">
            <input
                type="text"
                name="search"
                placeholder="Buscar por título ou comércio..."
                value="{{ request('search') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 w-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            >
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
                    :acoes="[
    [
        'label' => 'Ativar',
        'class' => 'bg-green-600 text-white hover:bg-green-700',
   'onClick' => "window.location.href='{{ route('cupom.ativar', ['id' => $cupom->id_promo]) }}'"

                ]
]"
                />
            @empty
                <p class="text-gray-500 text-center col-span-full py-6">
                    Nenhum cupom encontrado.
                </p>
            @endforelse
        </div>
    </div>
@endsection
