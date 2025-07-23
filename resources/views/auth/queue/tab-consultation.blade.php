<!-- Consultation -->
<div class="w-full flex flex-col items-center bg-white rounded-lg shadow">
    @if ($queue->doctor_selected_at === null)
    <div class="w-full">
        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800">Please Select a Doctor</h3>
            </div>
        </div>
    </div>

    @elseif ($queue->assessment_started_at === null || $queue->assessment_done_at === null)
    <div class="w-full">
        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800">Please Fill Up Assessment Form</h3>
            </div>
        </div>
    </div>

    @elseif ($queue->consultation_started_at === null)
    <form id="StartConsultingForm"
        method="POST"
        action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
        class="w-full">
        @csrf
        @method('PUT')

        <input type="hidden" name="queue_action" value="Start Consultation">

        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <x-forms.primary-button
                    type="button"
                    onclick="updateQueue('StartConsultingForm')"
                    :disabled="!in_array(auth()->user()->role, ['admin', 'doctor'])">
                    Start Consultation
                </x-forms.primary-button>
            </div>
        </div>
    </form>

    @elseif ($queue->consultation_started_at != null)

    @role(['admin', 'doctor'])
    @include('auth.queue.form-consultation')

    @else
    <div class="w-full">
        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800">Consultation in Progress</h3>
            </div>
        </div>
    </div>
    @endrole



    @endif

</div>

<!-- Validation -->
<script>
    function restrictLetterInput(input) {
        input.value = input.value.replace(/[^0-9\-\/]/g, '');
    }
</script>


<!-- Test -->
<script>
    function fillConsultationFields() {
        const testData = {
            findings: "Normal vitals except for slight dehydration",
            diagnosis: "Migraine",
            recommended_treatment: "Painkillers and hydration",
            follow_up_instructions: "Return in 1 week if symptoms persist",
            referrals: "Neurologist consultation",

            doctor_notes: "Patient advised to rest and monitor symptoms",
        };

        document.getElementById('findings').value = testData.findings;
        document.getElementById('diagnosis').value = testData.diagnosis;
        document.getElementById('recommended_treatment').value = testData.recommended_treatment;
        document.getElementById('follow_up_instructions').value = testData.follow_up_instructions;
        document.getElementById('referrals').value = testData.referrals;

        document.getElementById('doctor_notes').value = testData.doctor_notes;

        console.log("Fields filled with test data!");
    }
</script>