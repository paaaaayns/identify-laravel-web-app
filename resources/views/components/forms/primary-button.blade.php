<button {{ $attributes->merge([
    'class' => 'rounded-md bg-button-primary px-3 py-2 text-sm font-semibold text-white shadow-sm 
            hover:bg-button-primary-hover 
            focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary'
    ]) }}>
    {{ $slot }}
</button>

