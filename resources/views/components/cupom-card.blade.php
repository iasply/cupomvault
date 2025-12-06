@php use Illuminate\Support\Carbon; @endphp
@props(['cupom', 'acoes' => [], 'showStatus' => true, 'modal' => false])

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

    $detalhesUrl = $cupom->id_promo
        ? url('cupomvault/comercio/cupons/detalhes/' . $cupom->id_promo)
        : url('cupomvault/comercio/cupons/detalhes');
@endphp


<div
    @if($modal && !empty($cupom->id_promo))
        data-cupom-id="{{ $cupom->id_promo }}"
    class="cursor-pointer border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition bg-white"
    @else
        class="border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition bg-white"
    @endif
>
    <div class="flex justify-between items-start mb-3">
        <h2 class="text-lg font-semibold text-gray-800">
            {{ $cupom->tit_cupom ?? 'Cupom sem título' }}
        </h2>

        @if($showStatus)
            <span class="px-2 py-1 rounded text-xs font-medium {{ $status_class }}">
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
                <strong>Emissão:</strong> {{ optional(Carbon::parse(@$cupom->dta_emissao_cupom ?? null))->format('d/m/Y') }}
            </p>
        @endif
        @if(!empty(@$cupom->dta_inicio_cupom))
            <p>
                <strong>Início:</strong> {{ optional(Carbon::parse(@$cupom->dta_inicio_cupom ?? null))->format('d/m/Y') }}
            </p>
        @endif
        @if(!empty(@$cupom->dta_termino_cupom))
            <p>
                <strong>Validade:</strong> {{ optional(Carbon::parse(@$cupom->dta_termino_cupom ?? null))->format('d/m/Y') }}
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
                    onclick="{{ $acao['onClick'] ?? '' }}; event.stopPropagation();"
                    class="px-3 py-2 rounded-md text-sm font-medium {{ $acao['class'] ?? 'bg-blue-600 text-white hover:bg-blue-700' }}"
                >
                    {{ $acao['label'] }}
                </button>
            @endforeach
        </div>
    @endif
</div>


<div id="modal-cupom" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div id="overlay-cupom" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    <div class="relative z-10 w-full max-w-lg bg-white rounded-xl shadow-xl border border-gray-200 p-6">

        <div id="resumo-cupom" class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200"></div>

        <div id="conteudo-modal-cupom" class="max-h-[60vh] overflow-y-auto text-gray-700 text-sm">
        </div>

        <div class="mt-6 flex justify-end">
            <button id="btn-close-cupom"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Fechar
            </button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modal-cupom');
        const overlay = document.getElementById('overlay-cupom');
        const btnClose = document.getElementById('btn-close-cupom');

        document.querySelectorAll('[data-cupom-id]').forEach(function (el) {
            el.addEventListener('click', async function (event) {
                event.stopPropagation();
                const id = el.dataset.cupomId;
                if (!id) return;

                const detalhesUrl = `{{ url('cupomvault/comercio/cupons/detalhes') }}/${id}`;

                try {
                    const resp = await fetch(detalhesUrl, {
                        headers: {'Accept': 'application/json'}
                    });

                    if (!resp.ok) {
                        console.error('Erro fetch cupom', resp.status);
                        return;
                    }

                    const dados = await resp.json();

                    const conteudo = modal.querySelector('#conteudo-modal-cupom');
                    const resumo = modal.querySelector('#resumo-cupom');

                    const usados = dados[0]?.usados ?? 0;
                    const faltam = dados[0]?.faltam ?? 0;

                    resumo.innerHTML = `
                    <div class="flex justify-between font-semibold text-gray-800 text-sm px-4 py-2 border-b rounded-md bg-gray-100">
                        <span>Usados: ${usados}</span>
                        <span>Restantes: ${faltam}</span>
                    </div>
                `;

                    conteudo.innerHTML = `
                    <div class="overflow-y-auto max-h-96">
                        <div class="grid grid-cols-[16ch_1fr_16ch] py-3 px-4 font-semibold border-b text-sm text-gray-700 items-center">
                            <span>Num Cupom</span>
                            <span>Status</span>
                            <span>Data Uso</span>
                        </div>
                        ${dados.map((item, index) => {
                        let statusClass;
                        switch (item.status.toLowerCase()) {
                            case 'utilizado':
                                statusClass = 'bg-red-200 text-red-800';
                                break;
                            case 'não utilizado':
                                statusClass = 'bg-blue-200 text-blue-800';
                                break;
                            case 'ativo':
                                statusClass = 'bg-green-200 text-green-900';
                                break;
                            case 'vencido':
                                statusClass = 'bg-yellow-200 text-yellow-900';
                                break;
                            default:
                                statusClass = 'bg-gray-200 text-gray-800';
                        }

                        const bg = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';

                        return `
                                <div class="grid grid-cols-[16ch_1fr_16ch] py-3 px-4 ${bg} border-b items-center text-sm gap-2">
                                    <span class="truncate font-medium">${item.num_cupom}</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium ${statusClass}">${item.status.toUpperCase()}</span>
                                    <span>${item.data_uso ?? '-'}</span>
                                </div>
                            `;
                    }).join('')}
                    </div>
                `;

                    modal.classList.remove('hidden');

                } catch (err) {
                    console.error(err);
                }
            });
        });

        overlay.addEventListener('click', () => modal.classList.add('hidden'));
        btnClose.addEventListener('click', () => modal.classList.add('hidden'));
    });
</script>
