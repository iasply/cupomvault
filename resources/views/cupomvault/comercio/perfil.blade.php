@php
    use App\Enums\CategoriaComercio;
@endphp
@extends('layouts.comercio')

@section('title', 'Meu Perfil')

@section('content')
    <x-container>
        <h1 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            👤 Meu Perfil
        </h1>

        <p class="text-gray-600 mb-8">
            Aqui estão as informações cadastradas do seu comércio.
            Você pode revisar seus dados para garantir que estão corretos.
        </p>

        {{-- Informações principais --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm text-gray-500">Razão Social</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $comercio->raz_social_comercio ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">Nome Fantasia</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $comercio->nom_fantasia_comercio ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">E-mail</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $comercio->email_comercio ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">CNPJ</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $comercio->cnpj_comercio ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">Telefone / Contato</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $comercio->con_comercio ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">Data de Cadastro</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $comercio->created_at ? $comercio->created_at->format('d/m/Y') : '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">Tipo de Comércio</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $comercio->id_categoria?->label() ?? '—' }}
                </div>
            </div>
        </div>

        {{-- Botões --}}
        <div class="flex justify-end mt-8 gap-3">
            <button
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition"
                onclick="alert('Em breve será possível editar o perfil!')">
                ✏️ Editar Perfil
            </button>
        </div>
    </x-container>
@endsection
