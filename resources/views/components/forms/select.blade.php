<select {{ $attributes->merge([
    'class' => 'bg-gray-50 text-gray-900 text-sm 
        rounded-lg border border-gray-300 
        focus:ring-primary focus:border-primary block !outline-none
        block w-full p-3'
]) }}>
    {{ $slot }}
</select>