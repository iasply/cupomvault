@php use Illuminate\Support\Carbon; @endphp
@props(['cupom', 'acoes' => []])

<div class="border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition bg-white">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">
        {{ $cupom->tit_cupom ?? 'Cupom sem título' }}
    </h2>

    <div class="text-gray-600 text-sm space-y-1 mb-4">
        @if(!empty(@$cupom->nom_fantasia_comercio))
            <p><strong>Comércio:</strong> {{ @$cupom->nom_fantasia_comercio }}</p>
        @endif
        @if(!empty(@$cupom->dta_emissao_cupom))
            <p>
                <strong>Emissão:</strong>
                {{ optional(Carbon::parse(@$cupom->dta_emissao_cupom ?? null))->format('d/m/Y') }}
            </p>
        @endif
        @if(!empty(@$cupom->dta_inicio_cupom))
            <p>
                <strong>Início:</strong>
                {{ optional(Carbon::parse(@$cupom->dta_inicio_cupom ?? null))->format('d/m/Y') }}
            </p>
        @endif

        @if(!empty(@$cupom->dta_termino_cupom))
            <p>
                <strong>Validade:</strong>
                {{ optional(Carbon::parse(@$cupom->dta_termino_cupom ?? null))->format('d/m/Y') }}
            </p>
        @endif

        @if(!is_null(@$cupom->per_desc_cupom ?? null))
            <p><strong>Desconto:</strong> {{ @$cupom->per_desc_cupom }}%</p>
        @endif
    </div>

    @if(!empty($acoes))
        <div class="flex flex-wrap gap-2">
            @foreach($acoes as $acao)
                <button
                    type="button"
                    onclick="{{ $acao['onClick'] ?? '' }}"
                    class="px-3 py-2 rounded-md text-sm font-medium
           {{ $acao['class'] ?? 'bg-blue-600 text-white hover:bg-blue-700' }}"
                >
                    {{ $acao['label'] }}
                </button>

            @endforeach
        </div>
    @endif
</div>
