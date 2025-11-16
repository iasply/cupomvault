@extends('layouts.app')

@section('title', 'Cupom Vault - Home')

@section('content')
    <x-container>

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
            Bem-vindo ao Cupom Vault 🎟️
        </h2>
        <p class="text-gray-600 mb-6">
            Escolha uma opção para continuar:
        </p>
        <div class="flex flex-col gap-4 mt-4">

            <a href="{{ route('comercio.login') }}"
               class="w-full py-3 text-center bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                Acessar como Comércio
            </a>

            <a href="{{ route('associado.login') }}"
               class="w-full py-3 text-center bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">
                Acessar como Associado
            </a>

        </div>
    </x-container>
@endsection
