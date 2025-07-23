<div class="inline-flex items-center mx-auto space-x-3">
    <a
        href="{{ $viewLink ?? '#' }}"
        class="text-primary">
        View
    </a>


    @role(['admin'])
    <form
        method="POST"
        action="{{ $deleteLink ?? '#' }}"
        id="delete-form-{{ $id }}"
        class="d-inline">
        @csrf
        @method('DELETE')

        <button
            type="button"
            class="btn btn-link text-red-500"
            onclick="confirmDelete('{{ $id }}')">
            Delete
        </button>
    </form>
    @endrole

</div>

<script>
    function confirmDelete(id) {
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
                const isVerified = await promptForPassword();
                if (isVerified) {
                    deleteUser(id);
                }
            }
        });
    }

    async function deleteUser(id) {
        const form = document.getElementById('delete-form-' + id);

        try {
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
                Livewire.dispatch('refreshTable');
            } else {
                showToast('toast-error', result.message);
                console.error('Error:', result.message);
            }
        } catch (error) {
            showToast('toast-error', 'An error occurred while processing the request.');
            console.error('Error:', error);
        }
    }
</script>