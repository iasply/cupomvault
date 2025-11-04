@props([
    'label' => null,
    'name',
    'type' => 'text',
    'min' => null,
    'max' => null,
    'required' => false,
    'maxlength' => null,
])

<div class="space-y-1">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">
            {{ $label }}
        </label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        @if($min) min="{{ $min }}" @endif
        @if($max) max="{{ $max }}" @endif
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        value="{{ old($name) }}"
        {{ $attributes->merge([
            'class' => '
                w-full
                border border-gray-300
                rounded-xl  /* borda mais quadradinha, mas ainda elegante */
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

    @error($name)
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
