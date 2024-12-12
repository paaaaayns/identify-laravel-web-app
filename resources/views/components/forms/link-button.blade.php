<a {{ $attributes->merge([
    'class' => '',]) }}>

    <div class="bg-primary px-3 py-2
            text-sm font-semibold text-white
            rounded-md shadow-sm
            hover:bg-primary
            focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">{{ $slot }}</div>
</a>