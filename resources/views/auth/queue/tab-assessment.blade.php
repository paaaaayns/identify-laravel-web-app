<!-- Assessment -->
<div class="w-full flex flex-col items-center bg-white rounded-lg shadow">

    @if ($queue->doctor != null)
    @include('auth.queue.form-assessment')

    @else
    <div class="w-full">
        <div class="grid grid-cols-1 text-center">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800">Please Select a Doctor</h3>
            </div>
        </div>
    </div>

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
    function fillAssessmentFields() {
        // Predefined values for testing
        const testData = {
            primary_complaint: "Headache and nausea",
            duration_of_symptoms: "3 days",
            intensity_and_frequency: "Moderate, occurs twice daily",

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
        document.getElementById('primary_complaint').value = testData.primary_complaint;
        document.getElementById('duration_of_symptoms').value = testData.duration_of_symptoms;
        document.getElementById('intensity_and_frequency').value = testData.intensity_and_frequency;

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