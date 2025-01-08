<form id="AssessmentForm"
    method="POST"
    action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
    class="w-full">
    @csrf
    @method('PUT')

    <input type="hidden" name="queue_status" value="Assessment Done">

    <div class="grid grid-cols-1">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800">Current Concerns</h3>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="primary_complaint">
                        Primary Complaint
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="primary_complaint"
                        name="primary_complaint"
                        rows="3"
                        :value="$queue->primary_complaint"
                        :disabled="$queue->primary_complaint ? true : false" />
                    <x-forms.error name="primary_complaint" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="duration_of_symptoms">
                        Duration of Symptoms
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="duration_of_symptoms"
                        name="duration_of_symptoms"
                        rows="3"
                        :value="$queue->duration_of_symptoms"
                        :disabled="$queue->duration_of_symptoms ? true : false" />
                    <x-forms.error name="duration_of_symptoms" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="intensity_and_frequency">
                        Intensity & Frequency
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="intensity_and_frequency"
                        name="intensity_and_frequency"
                        rows="3"
                        :value="$queue->intensity_and_frequency"
                        :disabled="$queue->intensity_and_frequency ? true : false" />
                    <x-forms.error name="intensity_and_frequency" />
                </x-forms.field-container>
            </div>
        </div>

        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800">Assessment</h3>
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
                        :disabled="$queue->height ? true : false" />
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
                        :disabled="$queue->weight ? true : false" />
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
                        :disabled="$queue->blood_pressure ? true : false" />
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
                        :disabled="$queue->temperature ? true : false" />
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
                        :disabled="$queue->respiration_rate ? true : false" />
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
                        :disabled="$queue->o2_sat ? true : false" />
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
                        :disabled="$queue->other ? true : false" />
                    <x-forms.error name="other" />
                </x-forms.field-container>
            </div>
        </div>

        @role(['admin', 'doctor', 'opd'])
        @if ($queue->queue_status != 'Completed')
        <div class="p-6">
            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
                <button
                    id="fill"
                    type="button"
                    onclick="fillAssessmentFields()"
                    class="rounded-md px-3 py-2 text-sm font-semibold text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                    Test
                </button>

                <x-forms.primary-button
                    type="button"
                    onclick="updateQueue('AssessmentForm')">
                    Save
                </x-forms.primary-button>
            </div>
        </div>
        @endif
        @endrole
    </div>
</form>