<p
    {{ $attributes->merge([
        'class' => 'block font-medium text-gray-900'
        ]) }}>
    {{ $slot }}
</p>