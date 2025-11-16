@props([
    'label' => null,
    'name',
    'options' => [],
    'default' => ''
])

<div class="space-y-1">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ $label }}
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge([
            'class' => '
                w-full
                border border-gray-300
                rounded-xl
                bg-gray-50
                px-3 py-2.5
                text-gray-800
                placeholder-gray-400
                focus:outline-none
                focus:ring-2 focus:ring-blue-500
                focus:border-blue-500
                transition-all
                duration-200
                shadow-sm
            '
        ]) }}
    >
        <option value="">{{ $default ?: 'Selecione' }}</option>

        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ old($name, request($name)) == $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>

</div>
