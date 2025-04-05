<div class="inline-flex items-center mx-auto space-x-3">

    <form
        method="POST"
        id="DoctorSelectionForm"
        action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="queue_action" value="Doctor Assigned">
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

            const result = await response.json();

            if (response.ok) {
                showToast('toast-success', result.message);
                console.log(response.status, result.message, result.queue);
                location.reload();
            } else {
                showToast('toast-error', result.message);
                console.error(response.status, result.message);
            }
        } catch (error) {
            showToast('toast-error', 'An error occurred while processing the request.');
            console.error('Fetch error:', error);
            return null;
        }
    }
</script>