@php
    use App\Enums\CategoriaComercio;

    $tipoComercios = collect(CategoriaComercio::cases())
        ->mapWithKeys(fn($c) => [$c->value => $c->label()]);
@endphp

@extends('layouts.associado')

@section('title', 'Home do Associado')

@section('content')

    <x-container>

        <h1 class="text-3xl font-bold mb-4 text-gray-800">🎟️ Bem-vindo!</h1>

        <p class="text-gray-600 mb-8">
            Aqui você pode buscar por novos cupons ou ativar os disponíveis.
        </p>

        <x-filtro-busca
            :action="route('associado.home')"
            method="GET"
            :filtros="[[
            'label' => 'Categoria',
            'name' => 'comercio',
            'options' => $tipoComercios
        ]]"
        />

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($cupons as $cupom)
                <x-cupom-card
                    :cupom="$cupom"
                    :acoes="[
                        [
                            'label' => 'Ativar',
                            'class' => 'bg-green-600 text-white hover:bg-green-700',
                            'onClick' => 'window.location.href=\''.route('cupom.ativar', ['id' => $cupom->id_promo]).'\''
                        ]
                    ]"
                    :showStatus="false"
                />
            @empty
                <p class="col-span-full py-6 text-center text-gray-500">
                    Nenhum cupom encontrado.
                </p>
            @endforelse
        </div>
    </x-container>

@endsection
