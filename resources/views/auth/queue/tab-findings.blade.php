<!-- Findings -->
<div class="w-full flex flex-col items-center">
    <form
        method="POST"
        id="FindingsForm"
        action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
        class="w-full">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">

                <h3 class="text-xl font-semibold text-gray-800">Vitals Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                    <x-forms.field-container class="sm:col-span-3">
                        <x-forms.label
                            for="height">
                            Height (cm)
                        </x-forms.label>
                        <x-forms.input
                            type="text"
                            id="height"
                            name="height"
                            :value="$queue->height"
                            autocomplete="off"
                            oninput="restrictLetterInput(this)"
                            :disabled="$queue->pulse_rate ? true : false" />
                        <x-forms.error name="height" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-3">
                        <x-forms.label
                            for="weight">
                            Weight (kg)
                        </x-forms.label>
                        <x-forms.input
                            type="text"
                            id="weight"
                            name="weight"
                            :value="$queue->weight"
                            autocomplete="off"
                            oninput="restrictLetterInput(this)"
                            :disabled="$queue->pulse_rate ? true : false" />
                        <x-forms.error name="weight" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-3">
                        <x-forms.label
                            for="blood_pressure">
                            Blood Pressure (mmHg)
                        </x-forms.label>
                        <x-forms.input
                            type="text"
                            id="blood_pressure"
                            name="blood_pressure"
                            :value="$queue->blood_pressure"
                            autocomplete="off"
                            oninput="restrictLetterInput(this)"
                            :disabled="$queue->pulse_rate ? true : false" />
                        <x-forms.error name="blood_pressure" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-3">
                        <x-forms.label
                            for="temperature">
                            Temperature (°C)
                        </x-forms.label>
                        <x-forms.input
                            type="text"
                            id="temperature"
                            name="temperature"
                            :value="$queue->temperature"
                            autocomplete="off"
                            oninput="restrictLetterInput(this)"
                            :disabled="$queue->pulse_rate ? true : false" />
                        <x-forms.error name="temperature" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-3">
                        <x-forms.label
                            for="pulse_rate">
                            Pulse Rate (bpm)
                        </x-forms.label>
                        <x-forms.input
                            type="text"
                            id="pulse_rate"
                            name="pulse_rate"
                            :value="$queue->pulse_rate"
                            autocomplete="off"
                            oninput="restrictLetterInput(this)"
                            :disabled="$queue->pulse_rate ? true : false" />
                        <x-forms.error name="pulse_rate" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-3">
                        <x-forms.label
                            for="respiration_rate">
                            Respiration Rate (bpm)
                        </x-forms.label>
                        <x-forms.input
                            type="text"
                            id="respiration_rate"
                            name="respiration_rate"
                            :value="$queue->respiration_rate"
                            autocomplete="off"
                            oninput="restrictLetterInput(this)"
                            :disabled="$queue->pulse_rate ? true : false" />
                        <x-forms.error name="respiration_rate" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-3">
                        <x-forms.label
                            for="o2_sat">
                            Oxygen Saturation (%)
                        </x-forms.label>
                        <x-forms.input
                            type="text"
                            id="o2_sat"
                            name="o2_sat"
                            :value="$queue->o2_sat"
                            autocomplete="off"
                            oninput="restrictLetterInput(this)"
                            :disabled="$queue->pulse_rate ? true : false" />
                        <x-forms.error name="o2_sat" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-12">
                        <x-forms.label
                            for="other">
                            Other
                        </x-forms.label>
                        <x-forms.textarea
                            type="text"
                            id="other"
                            name="other"
                            rows="4"
                            :value="$queue->other" 
                            :disabled="$queue->pulse_rate ? true : false" />
                        <x-forms.error name="other" />
                    </x-forms.field-container>
                </div>
            </div>

            <div class="p-6">
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
                    <button
                        id="fill"
                        type="button"
                        onclick="fillFields()"
                        class="rounded-md px-3 py-2 text-sm font-semibold text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                        Test
                    </button>

                    <x-forms.primary-button
                        type="button"
                        onclick="updateQueue()">
                        Save
                    </x-forms.primary-button>

                    @if (true)
                    <x-forms.primary-button
                        type="submit">
                        Override
                    </x-forms.primary-button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Validation -->
<script>
    function restrictLetterInput(input) {
        // Remove non-numeric characters
        input.value = input.value.replace(/[^0-9\-\/]/g, '');
    }
</script>

<script>
    async function updateQueue() {
        const form = document.getElementById('VitalsForm');
        const formData = new FormData(form);
        const formAction = form.action;

        try {
            const response = await fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const result = await response.json();
                showToast('toast-success', result.message);
                console.log(response.status, result.message, result.queue);
            } else {
                showToast('toast-error', 'Failed to update queue.');
                console.error(response.status, 'Failed to update queue.');
            }
        } catch (error) {
            showToast('toast-error', 'An error occurred while processing the request.');
            console.error(response.status, error);
            return null;
        }
    }
</script>

<!-- Test -->
<script>
    function fillFields() {
        // Predefined values for testing
        const testData = {
            height: "175",
            weight: "80",
            blood_pressure: "120/80",
            temperature: "37",
            pulse_rate: "70",
            respiration_rate: "20",
            o2_sat: "95",

            other: "N/A",
        };

        // Fill fields using their IDs
        document.getElementById('height').value = testData.height;
        document.getElementById('weight').value = testData.weight;
        document.getElementById('blood_pressure').value = testData.blood_pressure;
        document.getElementById('temperature').value = testData.temperature;
        document.getElementById('pulse_rate').value = testData.pulse_rate;
        document.getElementById('respiration_rate').value = testData.respiration_rate;
        document.getElementById('o2_sat').value = testData.o2_sat;

        document.getElementById('other').value = testData.other;

        console.log("Fields filled with test data!");
    }
</script>