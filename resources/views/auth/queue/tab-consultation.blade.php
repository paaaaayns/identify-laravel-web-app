<!-- Consultation -->
<div class="w-full flex flex-col items-center bg-white rounded-lg shadow">

    @if ($queue->queue_status == 'Consulting' || $queue->queue_status == 'Completed')
    <form id="ConsultationForm"
        method="POST"
        action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
        class="w-full">
        @csrf
        @method('PUT')

        <input type="hidden" name="queue_status" value="Completed">

        <div class="grid grid-cols-1">
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

    @elseif ($queue->queue_status == 'Assessment Done')
    <form id="StartConsultingForm"
        method="POST"
        action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
        class="w-full">
        @csrf
        @method('PUT')

        <input type="hidden" name="queue_status" value="Consulting">

        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <x-forms.primary-button
                    type="button"
                    onclick="updateQueue('StartConsultingForm')">
                    Start Consultation
                </x-forms.primary-button>
            </div>
        </div>
    </form>

    @else
    @if ($queue->doctor != null)
    <div class="w-full">
        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800">Please Fill Up Prep Form</h3>
            </div>
        </div>
    </div>
    @else
    <div class="w-full">
        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800">Please Select a Doctor</h3>
            </div>
        </div>
    </div>
    @endif


    @endif

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
            findings: "Normal vitals except for slight dehydration",
            diagnosis: "Migraine",
            recommended_treatment: "Painkillers and hydration",
            follow_up_instructions: "Return in 1 week if symptoms persist",
            referrals: "Neurologist consultation",

            doctor_notes: "Patient advised to rest and monitor symptoms",
        };

        // Fill fields using their IDs
        document.getElementById('findings').value = testData.findings;
        document.getElementById('diagnosis').value = testData.diagnosis;
        document.getElementById('recommended_treatment').value = testData.recommended_treatment;
        document.getElementById('follow_up_instructions').value = testData.follow_up_instructions;
        document.getElementById('referrals').value = testData.referrals;

        document.getElementById('doctor_notes').value = testData.doctor_notes;

        console.log("Fields filled with test data!");
    }
</script>