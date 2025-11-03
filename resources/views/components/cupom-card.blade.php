@if($cupons->isEmpty())
    <p class="text-gray-600">Nenhum cupom encontrado.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($cupons as $cupom)
            <div class="border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                @if($cupom->tit_cupom)
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $cupom->tit_cupom }}</h2>
                @endif

                @if($cupom->nome_fantasia_comercio)
                    <p class="text-gray-600 mb-1"><strong>Comércio:</strong> {{ $cupom->nome_fantasia_comercio }}</p>
                @endif

                @if($cupom->dta_emissao_cupom)
                    <p class="text-gray-600 mb-1">
                        <strong>Emissão:</strong> {{ $cupom->dta_emissao_cupom->format('d/m/Y') }}
                    </p>
                @endif

                @if($cupom->dta_inicio_cupom)
                    <p class="text-gray-600 mb-1">
                        <strong>Início:</strong> {{ $cupom->dta_inicio_cupom->format('d/m/Y') }}
                    </p>
                @endif

                @if($cupom->dta_termino_cupom)
                    <p class="text-gray-600 mb-1">
                        <strong>Término:</strong> {{ $cupom->dta_termino_cupom->format('d/m/Y') }}
                    </p>
                @endif

                @if(!is_null($cupom->per_desc_cupom))
                    <p class="text-gray-600 mb-1"><strong>Desconto:</strong> {{ $cupom->per_desc_cupom }}%</p>
                @endif
            </div>
        @endforeach
    </div>

    @if(method_exists($cupons, 'links'))
        <div class="mt-6">
            {{ $cupons->withQueryString()->links() }}
        </div>
    @endif
@endif
