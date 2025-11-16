@extends('layouts.comercio')

@section('title', 'Meus Cupons')

@section('content')
    <x-container>
        <h1 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            🧾 Meus Cupons
        </h1>

        <p class="text-gray-600 mb-8">
            Aqui estão todos os cupons cadastrados para o seu comércio.
        </p>

        <x-filtro-busca
            :action="route('comercio.cupons')"
            method="GET"
        />


        <!-- Componente de cupons -->
        @if($cupons->isEmpty())
            <p class="text-gray-600">Nenhum cupom encontrado.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($cupons as $cupom)
                    <x-cupom-card
                        :cupom="$cupom"
                        :acoes="[
                    ['label' => 'Editar', 'class' => 'bg-yellow-500 text-white hover:bg-yellow-600', 'onClick' => 'window.location.href=`/cupom/edit/'.$cupom->id_promo.'`'],
                    ['label' => 'Excluir', 'class' => 'bg-red-500 text-white hover:bg-red-600', 'onClick' => 'if(confirm(`Excluir este cupom?`)) window.location.href=`/cupom/delete/'.$cupom->id_promo.'`']
//                    ,['label' => 'Desativar', 'class' => 'bg-gray-300 text-gray-800 hover:bg-gray-400'],
                ]"
                        :showStatus="false"
                    />
                @endforeach
            </div>

            @if(method_exists($cupons, 'links'))
                <div class="mt-6">
                    {{ $cupons->withQueryString()->links() }}
                </div>
            @endif
        @endif


        <div class="flex justify-end mt-8">
            <button id="openModal"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition">
                ➕ Novo Cupom
            </button>
        </div>

    </x-container>

    <!-- Modal de criação de cupons -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center hidden">
        <div id="overlay" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <div class="bg-white rounded-2xl p-8 w-full max-w-md relative z-10 shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                Criar Cupons
            </h2>

            <form action="{{ route('cupom.create') }}" method="POST" class="space-y-5">
                @csrf

                <x-input label="Título do Cupom" name="tit_cupom" maxlength="25" required/>
                <x-input label="Quantidade de Cupons" name="quantidade" type="number" min="1" max="100" required/>
                <x-input label="Data de Início" name="dta_inicio_cupom" type="date" required/>
                <x-input label="Data de Validade" name="dta_termino_cupom" type="date" required/>
                <x-input label="Porcentagem de Desconto (%)" name="per_desconto" type="number" min="1" max="100"
                         required/>

                <div class="flex justify-end gap-2 pt-4">
                    <button
                        type="button"
                        id="closeModal"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Criar
                    </button>
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
