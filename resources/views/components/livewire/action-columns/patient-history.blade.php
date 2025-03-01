<div class="inline-flex items-center mx-auto space-x-3">
    <button
        onclick="getRecord('{{ $record_ulid }}')"
        class="text-primary">
        View
    </button>
</div>

<script>
    function displayULID(record_ulid) {
        showToast('toast-success', record_ulid);

        // displayULID('{{ $record_ulid }}')
    }


    async function getRecord(record_ulid) {
        // console.log("record_ulid", record_ulid);
        try {
            const response = await fetch(`/api/medical-record/${record_ulid}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });


            const result = await response.json();
            if (response.ok) {
                showToast('toast-success', result.message);
                console.log(response.status, result.message);
            } else {
                showToast('toast-error', result.message);
                console.error(response.status, result.message);
            }

            updateFields(result.data);
        } catch (error) {
            showToast('toast-error', 'An error occurred while processing the request.');
            console.error('Fetch error:', error);
            return null;
        }
    }

    function updateFields(data) {
        console.log("@updateFields: data", data);

        // Mapping Patient fields to their corresponding HTML element IDs
        const patientFields = {
            "p-user_id": data.patient?.user_id ?? "N/A",
            "p-first_name": data.patient?.first_name ?? "N/A",
            "p-middle_name": data.patient?.middle_name ?? "N/A",
            "p-last_name": data.patient?.last_name ?? "N/A",
            "p-sex": data.patient?.sex ?? "N/A",
            "p-birthdate": data.patient?.birthdate ?? "N/A",
            "p-religion": data.patient?.religion ?? "N/A",
            "p-citizenship": data.patient?.citizenship ?? "N/A"
        };

        // Mapping Doctor fields to their corresponding HTML element IDs
        const doctorFields = {
            "d-name": `${data.doctor?.first_name ?? "N/A"} ${data.doctor?.last_name ?? ""}`.trim(),
            "d-specialization": data.doctor?.type ?? "N/A",
            "d-contact_number": data.doctor?.contact_number ?? "N/A",
            "d-email": data.doctor?.email ?? "N/A"
        };

        // Mapping Concerns fields (Medical Record)
        const recordFields = {
            "mr-created_at": formatDate(data.patient?.created_at),
            "mr-primary_complaint": data.primary_complaint ?? "N/A",
            "mr-duration_of_symptoms": data.duration_of_symptoms ?? "N/A",
            "mr-intensity_and_frequency": data.intensity_and_frequency ?? "N/A",
            "mr-findings": data.findings ?? "N/A",
            "mr-diagnosis": data.diagnosis ?? "N/A",
            "mr-recommended_treatment": data.recommended_treatment ?? "N/A",
            "mr-follow_up_instructions": data.follow_up_instructions ?? "N/A",
            "mr-referrals": data.referrals ?? "N/A",
            "mr-doctor_notes": data.doctor_notes ?? "N/A"
        };

        // Function to update fields dynamically
        function updateFieldsFromMap(fields) {
            Object.entries(fields).forEach(([id, value]) => {
                const element = document.querySelector(`#${id}`);
                if (element) element.textContent = value;
            });
        }

        // Function to format date
        function formatDate(dateString) {
            if (!dateString) return "N/A";
            const date = new Date(dateString);
            return date.toLocaleDateString("en-US", {
                year: "numeric",
                month: "long",
                day: "numeric"
            });
        }

        // Update all sections
        updateFieldsFromMap(patientFields);
        updateFieldsFromMap(doctorFields);
        updateFieldsFromMap(recordFields);
    }
</script>