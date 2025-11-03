@extends('layouts.comercio')

@section('title', 'Meus Cupons')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow-md rounded-xl p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            🧾 Meus Cupons
        </h1>

        <p class="text-gray-600 mb-8">
            Aqui estão todos os cupons cadastrados para o seu comércio.
        </p>

        <!-- Componente de cupons -->
        <x-cupom-card :cupons="$cupons" />

        <div class="flex justify-end mt-8">
            <button id="openModal"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition">
                ➕ Novo Cupom
            </button>
        </div>
    </div>

    <!-- Modal de criação de cupons -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-white/30 backdrop-blur-sm" id="overlay"></div>

        <div class="bg-white rounded-xl p-8 w-full max-w-md relative z-10 shadow-lg">
            <h2 class="text-xl font-bold mb-4">Criar Cupons</h2>
            <form action="{{ route('cupom.create') }}" method="POST">
                @csrf
                <x-input label="Título dos Cupons" name="tit_cupom" maxlength="25" required />
                <x-input label="Quantidade de Cupons" name="quantidade" type="number" min="1" max="100" required />
                <x-input label="Data de Início" name="dta_inicio_cupom" type="date" required />
                <x-input label="Data de Validade" name="dta_termino_cupom" type="date" required />
                <x-input label="Porcentagem de Desconto" name="per_desconto" type="number" min="1" max="100" required />

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Criar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modal');
        const overlay = document.getElementById('overlay');
        document.getElementById('openModal').addEventListener('click', () => modal.classList.remove('hidden'));
        document.getElementById('closeModal').addEventListener('click', () => modal.classList.add('hidden'));
        overlay.addEventListener('click', () => modal.classList.add('hidden'));
    </script>
@endsection
