<!-- Consultation -->
<div class="w-full flex flex-col items-center bg-white rounded-lg shadow">


    @if ($queue->queue_status == 'Completed')
    @include('auth.queue.form-consultation')

    @elseif ($queue->queue_status == 'Consulting')
    @role(['admin', 'doctor'])
    @include('auth.queue.form-consultation')

    @else
    <div class="w-full">
        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800">Ongoing Consultation</h3>
            </div>
        </div>
    </div>
    @endrole

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
                <h3 class="text-xl font-semibold text-gray-800">Please Fill Up Assessment Form</h3>
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