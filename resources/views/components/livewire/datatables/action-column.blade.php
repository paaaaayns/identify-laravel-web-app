<div class="inline-flex items-center mx-auto space-x-3">
    <a
        href="{{ $viewLink ?? '#' }}"
        class="text-primary">
        View
    </a>

    @if ($user->account_type === 'ADMIN')
    <form
        method="POST"
        action="{{ $deleteLink ?? '#' }}"
        id="delete-form-{{ $user_id }}"
        class="d-inline">
        @csrf
        @method('DELETE')

        <button
            type="button"
            class="btn btn-link text-red-500"
            onclick="confirmDelete('{{ $user_id }}')">
            Delete
        </button>
    </form>
    @endif

</div>

<script>
    // Confirmation dialog
    function confirmDelete(user_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            customClass: {
                confirmButton: 'bg-primary text-white px-6 py-3',
                cancelButton: 'bg-red-500 text-white px-6 py-3',
            },
        }).then(async (result) => {
            if (result.isConfirmed) {
                // Ask for password
                const isVerified = await promptForPassword();
                if (isVerified) {
                    deleteUser(user_id);
                }
            }
        });
    }

    // Deletion process
    async function deleteUser(user_id) {
        const form = document.getElementById('delete-form-' + user_id);

        try {
            // Perform the DELETE request using Fetch API
            const response = await fetch(form.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            if (response.ok) {
                const result = await response.json();
                showToast('toast-success', result.message);
                console.log('Success:', result.message);
                Livewire.dispatch('refreshTable'); // Dispatch the Livewire event to refresh the table
            } else {
                showToast('toast-error', 'Failed to delete the record.');
                console.error('Error:', 'Failed to delete the record.');
            }
        } catch (error) {
            showToast('toast-error', 'An error occurred while processing the request.');
            console.error('Error:', error);
        }
    }
</script>