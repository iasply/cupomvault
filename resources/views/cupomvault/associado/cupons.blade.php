@php
    use App\Enums\CategoriaComercio;

    $tipoComercios = collect(CategoriaComercio::cases())
        ->mapWithKeys(fn($c) => [$c->value => $c->label()]);
@endphp
@extends('layouts.associado')

@section('title', 'Meus Cupons')

@section('content')


    <x-container>


        <h1 class="text-3xl font-bold mb-4 text-gray-800">🎟️ Meus Cupons</h1>

        <x-filtro-busca
            :action="route('associado.cupons')"

        />

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

        <div class="mt-8">
            {{ $cupons->withQueryString()->links() }}
        </div>
    </x-container>
@endsection
