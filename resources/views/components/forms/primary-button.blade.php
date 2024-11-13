<button {{ $attributes->merge([
    'class' => 'bg-primary
        text-white font-medium text-sm
        rounded-lg
        ring-primary ring-offset-2 ring-offset-slate-50 focus:outline-none focus:ring-2
        px-5 py-2.5',
        
    ]) }}>

    {{ $slot }}
</button>


<!-- px-4 py-2 
font-semibold text-sm text-slate-700
bg-white border border-slate-300 
rounded-md shadow-sm 
ring-violet-300 ring-offset-2 ring-offset-slate-50 focus:outline-none focus:ring-2 -->