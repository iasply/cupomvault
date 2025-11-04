@props(['cupom', 'acoes' => []])

<div class="border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition bg-white">
    {{-- Cabeçalho --}}
    <h2 class="text-lg font-semibold text-gray-800 mb-3">
        {{ $cupom->tit_cupom ?? 'Cupom sem título' }}
    </h2>

    {{-- Informações do cupom --}}
    <div class="text-gray-600 text-sm space-y-1 mb-4">
        @if($cupom->nome_fantasia_comercio)
            <p><strong>Comércio:</strong> {{ $cupom->nome_fantasia_comercio }}</p>
        @endif

        @if($cupom->dta_inicio_cupom)
            <p><strong>Início:</strong> {{ $cupom->dta_inicio_cupom->format('d/m/Y') }}</p>
        @endif

        @if($cupom->dta_termino_cupom)
            <p><strong>Validade:</strong> {{ $cupom->dta_termino_cupom->format('d/m/Y') }}</p>
        @endif

        @if(!is_null($cupom->per_desc_cupom))
            <p><strong>Desconto:</strong> {{ $cupom->per_desc_cupom }}%</p>
        @endif
    </div>

    {{-- Botões configuráveis --}}
    @if(!empty($acoes))
        <div class="flex flex-wrap gap-2">
            @foreach($acoes as $acao)
                <button
                    type="button"
                    @click="{{ $acao['onClick'] ?? '' }}"
                    class="px-3 py-2 rounded-md text-sm font-medium
                           {{ $acao['class'] ?? 'bg-blue-600 text-white hover:bg-blue-700' }}"
                >
                    {{ $acao['label'] }}
                </button>
            @endforeach
        </div>
    @endif
</div>
