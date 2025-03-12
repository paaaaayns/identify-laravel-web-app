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
                        for="primary_complaint"
                        :required="true">
                        Primary Complaint
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="primary_complaint"
                        name="primary_complaint"
                        rows="3"
                        :value="$queue->primary_complaint"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="primary_complaint" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="duration_of_symptoms"
                        :required="true">
                        Duration of Symptoms
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="duration_of_symptoms"
                        name="duration_of_symptoms"
                        rows="3"
                        :value="$queue->duration_of_symptoms"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="duration_of_symptoms" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="intensity_and_frequency"
                        :required="true">
                        Intensity & Frequency
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="intensity_and_frequency"
                        name="intensity_and_frequency"
                        rows="3"
                        :value="$queue->intensity_and_frequency"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="intensity_and_frequency" />
                </x-forms.field-container>
            </div>
        </div>

        <div class="p-6 !pt-0">
            <h3 class="text-xl font-semibold text-gray-800">Vitals</h3>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                <x-forms.field-container class="sm:col-span-3">
                    <x-forms.label
                        for="height"
                        :required="true">
                        Height (cm)
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="height"
                        name="height"
                        autocomplete="off"
                        oninput="restrictLetterInput(this)"
                        :value="$queue->height"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="height" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-3">
                    <x-forms.label
                        for="weight"
                        :required="true">
                        Weight (kg)
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="weight"
                        name="weight"
                        autocomplete="off"
                        oninput="restrictLetterInput(this)"
                        :value="$queue->weight"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="weight" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-3">
                    <x-forms.label
                        for="blood_pressure"
                        :required="true">
                        Blood Pressure (mmHg)
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="blood_pressure"
                        name="blood_pressure"
                        autocomplete="off"
                        oninput="restrictLetterInput(this)"
                        :value="$queue->blood_pressure"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="blood_pressure" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-3">
                    <x-forms.label
                        for="temperature"
                        :required="true">
                        Temperature (°C)
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="temperature"
                        name="temperature"
                        autocomplete="off"
                        oninput="restrictLetterInput(this)"
                        :value="$queue->temperature"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="temperature" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-3">
                    <x-forms.label
                        for="pulse_rate"
                        :required="true">
                        Pulse Rate (bpm)
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="pulse_rate"
                        name="pulse_rate"
                        autocomplete="off"
                        oninput="restrictLetterInput(this)"
                        :value="$queue->pulse_rate"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="pulse_rate" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-3">
                    <x-forms.label
                        for="respiration_rate"
                        :required="true">
                        Respiration Rate (bpm)
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="respiration_rate"
                        name="respiration_rate"
                        autocomplete="off"
                        oninput="restrictLetterInput(this)"
                        :value="$queue->respiration_rate"
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="respiration_rate" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-3">
                    <x-forms.label
                        for="o2_sat"
                        :required="true">
                        Oxygen Saturation (%)
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="o2_sat"
                        name="o2_sat"
                        autocomplete="off"
                        oninput="restrictLetterInput(this)"
                        :value="$queue->o2_sat"
                        :disabled="$queue->assessment_done_at ? true : false" />
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
                        :disabled="$queue->assessment_done_at ? true : false" />
                    <x-forms.error name="other" />
                </x-forms.field-container>
            </div>
        </div>

        @role(['admin', 'doctor', 'opd'])
        @if (!$queue->assessment_done_at)
        <div class="p-6 !pt-0">
            <div class="flex items-center justify-end gap-x-4 border-t border-gray-900/10 pt-6">
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