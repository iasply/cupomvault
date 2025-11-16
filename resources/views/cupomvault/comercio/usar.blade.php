@extends('layouts.comercio')

@section('title', 'Ativar Cupom')

@section('content')
    <x-container>

        <h1 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            💸 Ativar Cupom
        </h1>

        <p class="text-gray-600 mb-8">
            Informe o CPF do associado e o código do cupom para ativá-lo.
        </p>

        <form action="{{ route('comercio.usar') }}" method="POST" class="space-y-6">
            @csrf

            {{-- CPF --}}
            <x-input
                label="CPF do Associado"
                name="cpf"
                maxlength="12"
                required="true"
            />

            {{-- Código do Cupom --}}
            <x-input
                label="Código do Cupom"
                name="num_cupom"
                maxlength="20"
                required="true"
            />

            {{-- Botão --}}
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                >
                    ✔️ Ativar
                </button>
            </div>

        </form>

    </x-container>
@endsection
