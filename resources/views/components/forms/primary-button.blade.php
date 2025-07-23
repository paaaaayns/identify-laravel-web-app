<button {{ $attributes->merge([
    'class' => '
        bg-primary px-3 py-2 
        text-sm font-semibold text-white 
        rounded-md shadow-sm 
        hover:bg-primary 
        focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary
        disabled:bg-gray-400 disabled:hover:bg-gray-400',
        
    ]) }}>

    {{ $slot }}
</button>


<!-- px-4 py-2 
font-semibold text-sm text-slate-700
bg-white border border-slate-300 
rounded-md shadow-sm 
ring-violet-300 ring-offset-2 ring-offset-slate-50 focus:outline-none focus:ring-2 -->