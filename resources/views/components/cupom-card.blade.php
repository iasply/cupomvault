@php use Illuminate\Support\Carbon; @endphp
@props(['cupom', 'acoes' => [],'showStatus'=>true] )

@php
    $now = Carbon::today();
    $status = 'não utilizado';
    $status_class = 'bg-gray-200 text-gray-800';

    if (!empty($cupom->dta_uso_cupom_associado)) {
        $status = 'utilizado';
        $status_class = 'bg-gray-300 text-gray-700';
    } else if (!empty($cupom->dta_termino_cupom) && Carbon::parse($cupom->dta_termino_cupom)->lt($now)) {
        $status = 'vencido';
        $status_class = 'bg-red-100 text-red-700';
    } else if (!empty($cupom->dta_inicio_cupom) && !empty($cupom->dta_termino_cupom)
               && Carbon::parse($cupom->dta_inicio_cupom)->lte($now)
               && Carbon::parse($cupom->dta_termino_cupom)->gte($now)) {
        $status = 'ativo';
        $status_class = 'bg-green-100 text-green-700';
    }
@endphp

<div class="border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition bg-white">
    <div class="flex justify-between items-start mb-3">
        <h2 class="text-lg font-semibold text-gray-800">
            {{ $cupom->tit_cupom ?? 'Cupom sem título' }}
        </h2>

        @if($showStatus) <span class="px-2 py-1 rounded text-xs font-medium {{ $status_class }}">
            {{ strtoupper($status) }}
        </span>
        @endif
    </div>

    <div class="text-gray-600 text-sm space-y-1 mb-4">
        @if(!empty(@$cupom->num_cupom))
            <p><strong>Numero do cupom: {{ @$cupom->num_cupom }}</strong></p>
        @endif
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

        @if(!empty(@$cupom->bai_comercio) && !empty(@$cupom->uf_comercio) && !empty(@$cupom->end_comercio) && !empty(@$cupom->cep_comercio))
            <p><strong>Endereço:</strong> {{ @$cupom->end_comercio }}</p>
            <p><strong>Uf:</strong> {{ @$cupom->uf_comercio }}</p>
            <p><strong>Bairro:</strong> {{ @$cupom->bai_comercio }}</p>
            <p><strong>Cep:</strong> {{ @$cupom->cep_comercio }}</p>
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
