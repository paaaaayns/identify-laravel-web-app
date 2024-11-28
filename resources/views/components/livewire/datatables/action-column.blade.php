<div class="inline-flex items-center mx-auto space-x-3">
    <a
        href="{{ $viewLink }}"
        class="text-primary">
        View
    </a>


    <button
        type="button"
        class="btn btn-link text-indigo-500"
        onclick="showToast('toast-error', 'Incorrect password.')">
        Edit
    </button>



    <form
        method="POST"
        action="{{ $deleteLink }}"
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
        }).then((result) => {
            if (result.isConfirmed) {
                // Ask for password
                promptForPassword(user_id);
            }
        });
    }

    // Prompt for password
    function promptForPassword(user_id) {
        Swal.fire({
            title: 'Confirm Your Identity',
            text: 'Please enter your password to continue.',
            input: 'password',
            inputPlaceholder: 'Enter your password',
            showCancelButton: true,
            confirmButtonText: 'Verify',
            customClass: {
                confirmButton: 'bg-primary text-white px-6 py-3',
                cancelButton: 'bg-red-500 text-white px-6 py-3',
                input: 'text-center',
            },
        }).then(async (result) => {
            if (result.isConfirmed) {
                const password = result.value;
                // Validate the password with the server
                const isValid = await verifyPassword(user_id, password);

                if (isValid) {
                    // Proceed to delete the record if password is correct
                    deleteUser(user_id);
                } else {
                    // Show an error message if password is invalid
                    showToast('toast-error', 'Incorrect password.');
                }
            }
        });
    }

    // Verify the password with the server (make a request to the server to check the password)
    async function verifyPassword(user_id, password) {
        try {
            const response = await fetch('/verify-password', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    user_id,
                    password
                }),
            });

            const result = await response.json();

            if (response.ok && result.success) {
                return true; // Password verified
            } else {
                return false; // Invalid password
            }
        } catch (error) {
            console.error('Error verifying password:', error);
            return false;
        }
    }

    // Deletion process
    async function deleteUser(user_id) {
        const form = document.getElementById('delete-form-' + user_id);

        console.log(user_id + " is being deleted...");

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
                console.log(result.message);

                showToast('toast-success', 'Record successfully deleted.')
                Livewire.dispatch('refreshTable'); // Dispatch the Livewire event to refresh the table
            } else {
                showToast('toast-error', 'Failed to delete the record.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }




    // Function to show success toast
    function showToast(toastID, message = '') {
        const toast = document.getElementById(toastID);
        const toastMessage = document.getElementById(toastID + '-message');

        // Set the custom message
        toastMessage.innerText = message;

        // Remove hidden class to make it visible
        toast.classList.remove('hidden');

        // Add animation for sliding down
        toast.classList.add('transition-transform', 'transform', 'translate-y-[-100%]'); // Start position (hidden above)

        // Trigger reflow to ensure the animation plays
        void toast.offsetWidth; // This forces a reflow

        // Slide down
        toast.classList.remove('translate-y-[-100%]');
        toast.classList.add('translate-y-0', 'duration-300', 'ease-out');

        // Hide the toast after 3 seconds with a slide-up animation
        setTimeout(() => {
            hideToast(toastID);
        }, 3000); // Duration before starting to slide up
    }

    // Function to hide toast (used by the close button)
    function hideToast(toastID) {
        const toast = document.getElementById(toastID);
        toast.classList.remove('translate-y-0');
        toast.classList.add('translate-y-[-100%]', 'duration-300', 'ease-in');

        // After the animation is done, hide it completely
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 300); // Wait for slide-up animation to finish before hiding
    }
</script>