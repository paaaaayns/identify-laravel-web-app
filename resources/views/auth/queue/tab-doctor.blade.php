<!-- Doctor Selection -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="text-xl font-semibold text-gray-800">Doctor Selection</h3>

    <div class="mt-6">

        @if ($queue->doctor_id == '')
        <livewire:doctor-selection-table :queue="$queue" />

        @else
        <x-forms.field-container class="sm:col-span-4">
            <x-forms.label
                for="doctor">
                Doctor
            </x-forms.label>
            @if (true)
            <x-forms.input
                type="text"
                id="doctor"
                name="doctor"
                :value="'Dr. ' . $doctor->first_name . ' ' . $doctor->middle_name . ' ' . $doctor->last_name"
                autocomplete="off"
                disabled />
            <x-forms.error name="doctor" />
            @endif
        </x-forms.field-container>
        @endif
    </div>

</div>