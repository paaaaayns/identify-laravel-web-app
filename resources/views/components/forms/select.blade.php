<select {{ $attributes->merge([
    'class' => '
        block w-full py-1.5 mt-2
        text-gray-900 sm:text-sm/6
        border-0 rounded-md shadow-sm
        ring-1 ring-inset ring-gray-300
        placeholder:text-gray-400
        focus:ring-2 focus:ring-inset focus:ring-primary
        
        disabled:bg-gray-100
        disabled:text-gray-900 disabled:opacity-100'
]) }}>
    {{ $slot }}
</select>