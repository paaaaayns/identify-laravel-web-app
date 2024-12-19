<!-- Vitals Information -->
<form method="POST" action="{{ route('queue.create') }}" id="QueueForm" class="grid grid-cols-1 gap-6">
    @csrf
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800">Vitals Information</h3>
        <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

            <x-forms.field-container class="sm:col-span-3">
                <x-forms.label
                    for="height">
                    Height (cm)
                </x-forms.label>
                @if (true)
                <x-forms.input
                    type="text"
                    id="height"
                    name="height"
                    :value="$profile->height"
                    autocomplete="off"
                    oninput="restrictLetterInput(this)" />
                <x-forms.error name="height" />
                @endif
            </x-forms.field-container>

            <x-forms.field-container class="sm:col-span-3">
                <x-forms.label
                    for="weight">
                    Weight (kg)
                </x-forms.label>
                @if (true)
                <x-forms.input
                    type="text"
                    id="weight"
                    name="weight"
                    :value="$profile->weight"
                    autocomplete="off"
                    oninput="restrictLetterInput(this)" />
                <x-forms.error name="weight" />
                @endif
            </x-forms.field-container>

            <x-forms.field-container class="sm:col-span-3">
                <x-forms.label
                    for="blood_pressure">
                    Blood Pressure (mmHg)
                </x-forms.label>
                @if (true)
                <x-forms.input
                    type="text"
                    id="blood_pressure"
                    name="blood_pressure"
                    :value="$profile->blood_pressure"
                    autocomplete="off"
                    oninput="restrictLetterInput(this)" />
                <x-forms.error name="blood_pressure" />
                @endif
            </x-forms.field-container>

            <x-forms.field-container class="sm:col-span-3">
                <x-forms.label
                    for="temperature">
                    Temperature (°C)
                </x-forms.label>
                @if (true)
                <x-forms.input
                    type="text"
                    id="temperature"
                    name="temperature"
                    :value="$profile->temperature"
                    autocomplete="off"
                    oninput="restrictLetterInput(this)" />
                <x-forms.error name="temperature" />
                @endif
            </x-forms.field-container>

            <x-forms.field-container class="sm:col-span-3">
                <x-forms.label
                    for="pulse_rate">
                    Pulse Rate (bpm)
                </x-forms.label>
                @if (true)
                <x-forms.input
                    type="text"
                    id="pulse_rate"
                    name="pulse_rate"
                    :value="$profile->pulse_rate"
                    autocomplete="off"
                    oninput="restrictLetterInput(this)" />
                <x-forms.error name="pulse_rate" />
                @endif
            </x-forms.field-container>

            <x-forms.field-container class="sm:col-span-3">
                <x-forms.label
                    for="respiration_rate">
                    Respiration Rate (bpm)
                </x-forms.label>
                @if (true)
                <x-forms.input
                    type="text"
                    id="respiration_rate"
                    name="respiration_rate"
                    :value="$profile->respiration_rate"
                    autocomplete="off"
                    oninput="restrictLetterInput(this)" />
                <x-forms.error name="respiration_rate" />
                @endif
            </x-forms.field-container>

            <x-forms.field-container class="sm:col-span-3">
                <x-forms.label
                    for="o2_sat">
                    Oxygen Saturation (%)
                </x-forms.label>
                @if (true)
                <x-forms.input
                    type="text"
                    id="o2_sat"
                    name="o2_sat"
                    :value="$profile->o2_sat"
                    autocomplete="off"
                    oninput="restrictLetterInput(this)" />
                <x-forms.error name="o2_sat" />
                @endif
            </x-forms.field-container>

            <x-forms.field-container class="sm:col-span-12">
                <x-forms.label
                    for="other">
                    Other
                </x-forms.label>
                @if (true)
                <x-forms.textarea
                    type="text"
                    id="other"
                    name="other"
                    rows="4"
                    :value="$profile->other" />
                <x-forms.error name="other" />
                @endif
            </x-forms.field-container>
        </div>

        <!-- Validation -->
        <script>
            function restrictLetterInput(input) {
                // Remove non-numeric characters
                input.value = input.value.replace(/[^0-9\.]/g, '');
            }
        </script>
    </div>

    <!-- Doctor Selection -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800">Doctor Selection</h3>

        <div class="mt-6">
            <livewire:doctor-selection-table />
        </div>
    </div>
</form>