@extends('layouts.associado')

@section('title', 'Meu Perfil')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            👤 Meu Perfil
        </h1>

        <p class="text-gray-600 mb-8">
            Aqui estão as informações cadastradas na sua conta de associado.
            Revise seus dados sempre que necessário.
        </p>

        {{-- Informações principais --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm text-gray-500">Nome Completo</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->nom_associado ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">CPF</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->cpf_associado ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">E-mail</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->email_associado ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">Celular</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->cel_associado ?? '—' }}
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm text-gray-500">Endereço</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->end_associado ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">Bairro</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->bai_associado ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">Cidade</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->cid_associado ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">UF</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->uf_associado ?? '—' }}
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-500">CEP</label>
                <div class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-1">
                    {{ $associado->cep_associado ?? '—' }}
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
    </div>
@endsection
