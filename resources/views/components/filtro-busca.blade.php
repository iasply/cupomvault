@php
    use App\Enums\CategoriaComercio;

    $tipoComercios = collect(CategoriaComercio::cases())
        ->mapWithKeys(fn($c) => [$c->value => $c->label()]);
@endphp

@props([
    'action' => '#',
    'method' => 'GET',
    'placeholder' => 'Buscar por Comercio ou Promoção...',
    'filtros' => [
        [
            'label' => 'Status',
            'name' => 'status',
            'options' => [
                'utilizado' => 'Utilizados',
                'vencido' => 'Vencidos',
                'ativos' => 'Ativos'
            ]
        ],
        [
            'label' => 'Categoria',
            'name' => 'comercio',
            'options' => $tipoComercios
        ]
    ],
    'btnLabel' => null,
    'btnAction' => null
])

<form action="{{ $action }}" method="{{ strtolower($method) === 'get' ? 'GET' : 'POST' }}"
      class="w-full bg-white p-4 rounded-xl shadow mb-6">

    @if(strtolower($method) !== 'get')
        @csrf
    @endif

    <div class="flex flex-col md:flex-row md:items-end gap-4">

        <div class="flex-1">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Busca</label>
            <input type="text"
                   name="busca"
                   value="{{ request('busca') }}"
                   placeholder="{{ $placeholder }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
        </div>

        @foreach($filtros as $filtro)
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ $filtro['label'] }}
                </label>

                <select name="{{ $filtro['name'] }}"
                        class="border rounded-lg px-3 py-2 w-full">
                    <option value="">Todos</option>

                    @foreach($filtro['options'] as $value => $text)
                        <option value="{{ $value }}"
                            {{ request($filtro['name']) == $value ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <div>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Buscar
            </button>
        </div>

        @if($btnLabel && $btnAction)
            <div>
                <button type="button"
                        onclick="{{ $btnAction }}"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 whitespace-nowrap">
                    {{ $btnLabel }}
                </button>
            </div>
        @endif
    </div>
</form>
