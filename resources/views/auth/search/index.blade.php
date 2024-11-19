<x-layout>

    <div>
        <div>

        @switch($type)
            @case('PRE-REG')
                    @include('livewire.pre-reg-table')
                @break

            @case('PATIENT')
                
                @break

            @case('DOCTOR')
                
                @break

            @case('OPD')
                
                @break
        
            @default
                
        @endswitch
        </div>
    </div>

</x-layout>