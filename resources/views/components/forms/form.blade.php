<form {{ $attributes->merge(['
    class' => 'bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl'
    ]) }}>
    
    {{ $slot }}
</form>