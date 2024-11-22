<x-pre-reg-layout>
    <div class="grid grid-cols-5 place-content-center h-full">
        <div class="col-start-2 col-span-3 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-gray-900 text-center">Track Your Pre-Registration</h2>
            <p class="text-gray-600 text-center mt-2">Enter your pre-registration code below to track your status.</p>

            <!-- Error message display -->
            @if(session('error'))
            <div class="bg-red-100 text-red-800 text-center p-4 rounded-md mt-4 ">
                {{ session('error') }}
            </div>
            @endif


            <!-- Search Form -->
            <form method="GET" action=" {{ route ('pre-reg.tracking.show') }} " class="mt-3 grid gap-4">
                <x-forms.input
                    type="text"
                    name="code"
                    placeholder="Enter Pre-Registration Code"
                    class="!p-3 !text-center !text-base" />

                <x-forms.primary-button type="submit" class="!py-3 !text-base !font-normal">
                    Search
                </x-forms.primary-button>
            </form>
        </div>
    </div>

</x-pre-reg-layout>