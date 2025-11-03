@extends('layouts.associado')

@section('title', 'Home do Associado')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Bem-vindo!</h1>
        <p class="text-gray-600 mb-6">
            Esta é sua área principal, procure por novos cupons ou veja os já utilizados.
        </p>

        <!-- Formulário de busca -->
        <form method="GET" action="{{ route('associado.home') }}" class="mb-6 flex gap-2">
            <input type="text" name="search" placeholder="Buscar por título ou comércio..."
                   value="{{ request('search') }}"
                   class="border border-gray-300 rounded px-3 py-2 w-full">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Buscar</button>
        </form>

        <!-- Componente de cupons -->
        <x-cupom-card :cupons="$cupons" />
    </div>
@endsection
