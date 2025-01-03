<!-- Consultation -->
<div class="w-full flex flex-col items-center bg-white rounded-lg shadow">
    <form
        method="POST"
        id="ConsultationForm"
        action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
        class="w-full">
        @csrf
        @method('PUT')

        <input type="hidden" name="queue_status" value="Completed">

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
                <h3 class="text-xl font-semibold text-gray-800">Consultation & Plans</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="findings">
                            Findings
                        </x-forms.label>
                        <x-forms.textarea
                            type="text"
                            id="findings"
                            name="findings"
                            rows="3"
                            :value="$queue->findings"
                            :disabled="$queue->findings ? true : false" />
                        <x-forms.error name="findings" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="diagnosis">
                            Diagnosis
                        </x-forms.label>
                        <x-forms.textarea
                            type="text"
                            id="diagnosis"
                            name="diagnosis"
                            rows="3"
                            :value="$queue->diagnosis"
                            :disabled="$queue->diagnosis ? true : false" />
                        <x-forms.error name="diagnosis" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="recommended_treatment">
                            Recommended Treatment
                        </x-forms.label>
                        <x-forms.textarea
                            type="text"
                            id="recommended_treatment"
                            name="recommended_treatment"
                            rows="3"
                            :value="$queue->recommended_treatment"
                            :disabled="$queue->recommended_treatment ? true : false" />
                        <x-forms.error name="recommended_treatment" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="follow_up_instructions">
                            Follow-up Instructions
                        </x-forms.label>
                        <x-forms.textarea
                            type="text"
                            id="follow_up_instructions"
                            name="follow_up_instructions"
                            rows="3"
                            :value="$queue->follow_up_instructions"
                            :disabled="$queue->follow_up_instructions ? true : false" />
                        <x-forms.error name="follow_up_instructions" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="referrals">
                            Referrals
                        </x-forms.label>
                        <x-forms.textarea
                            type="text"
                            id="referrals"
                            name="referrals"
                            rows="3"
                            :value="$queue->referrals"
                            :disabled="$queue->referrals ? true : false" />
                        <x-forms.error name="referrals" />
                    </x-forms.field-container>
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800">Others</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                    <x-forms.field-container class="sm:col-span-12">
                        <x-forms.label
                            for="doctor_notes">
                            Doctor's Notes
                        </x-forms.label>
                        <x-forms.textarea
                            type="text"
                            id="doctor_notes"
                            name="doctor_notes"
                            rows="3"
                            :value="$queue->doctor_notes"
                            :disabled="$queue->doctor_notes ? true : false" />
                        <x-forms.error name="doctor_notes" />
                    </x-forms.field-container>
                </div>
            </div>

            <div class="p-6">
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
                    <button
                        id="fill"
                        type="button"
                        onclick="fillConsultationFields()"
                        class="rounded-md px-3 py-2 text-sm font-semibold text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                        Test
                    </button>

                    <x-forms.primary-button
                        type="button"
                        onclick="updateQueue('ConsultationForm')">
                        Save
                    </x-forms.primary-button>
                </div>
            </div>
        </div>
    </form>

    <form
        method="POST"
        id="StartConsultingForm"
        action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
        class="w-full">
        @csrf
        @method('PUT')

    </form>

</div>

<!-- Validation -->
<script>
    function restrictLetterInput(input) {
        // Remove non-numeric characters
        input.value = input.value.replace(/[^0-9\-\/]/g, '');
    }
</script>


<!-- Test -->
<script>
    function fillConsultationFields() {
        // Predefined values for testing
        const testData = {
            primary_complaint: "Headache and nausea",
            duration_of_symptoms: "3 days",
            intensity_and_frequency: "Moderate, occurs twice daily",

            findings: "Normal vitals except for slight dehydration",
            diagnosis: "Migraine",
            recommended_treatment: "Painkillers and hydration",
            follow_up_instructions: "Return in 1 week if symptoms persist",
            referrals: "Neurologist consultation",

            doctor_notes: "Patient advised to rest and monitor symptoms",
        };

        // Fill fields using their IDs
        document.getElementById('primary_complaint').value = testData.primary_complaint;
        document.getElementById('duration_of_symptoms').value = testData.duration_of_symptoms;
        document.getElementById('intensity_and_frequency').value = testData.intensity_and_frequency;

        document.getElementById('findings').value = testData.findings;
        document.getElementById('diagnosis').value = testData.diagnosis;
        document.getElementById('recommended_treatment').value = testData.recommended_treatment;
        document.getElementById('follow_up_instructions').value = testData.follow_up_instructions;
        document.getElementById('referrals').value = testData.referrals;

        document.getElementById('doctor_notes').value = testData.doctor_notes;

        console.log("Fields filled with test data!");
    }
</script>