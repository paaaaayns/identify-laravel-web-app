<div class="inline-flex items-center mx-auto space-x-3">

    <form
        method="POST"
        id="DoctorSelectionForm"
        action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}">
        @csrf
        @method('PUT')
        <button
            type="button"
            onclick="updateDoctor('{{ $doctor_id }}')"
            class="text-primary">
            Select
        </button>
    </form>
</div>
<script>
    async function updateDoctor(doctor_id) {
        const form = document.getElementById('DoctorSelectionForm');
        const formAction = form.action;
        const formData = new FormData(form);
        // Append the doctor_id to the form data
        formData.append('doctor_id', doctor_id);

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
                location.reload();
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