@props([
    'required' => false
])

<label
    {{ $attributes->merge([
        'class' => 'block text-sm/6 font-medium text-gray-900'
        ]) }}>
    {{ $slot }} @if ($required) <span class="text-red-500">*</span> @endif
</label>