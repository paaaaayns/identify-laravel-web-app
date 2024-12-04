window.prototype = this;

import './bootstrap';
import Swal from 'sweetalert2';
import '../../vendor/rappasoft/laravel-livewire-tables/resources/imports/laravel-livewire-tables-all.js';




// Function to show success toast
window.showToast = function (toastID, message = '') {
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
window.hideToast = function (toastID) {
    const toast = document.getElementById(toastID);
    toast.classList.remove('translate-y-0');
    toast.classList.add('translate-y-[-100%]', 'duration-300', 'ease-in');

    // After the animation is done, hide it completely
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 300); // Wait for slide-up animation to finish before hiding
}



// Verify the password with the server (make a request to the server to check the password)
window.verifyPassword = async function (password) {
    try {
        const response = await fetch('/verify-password', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                'password' : password,
            }),
        });

        const result = await response.json();

        if (response.ok && result.success) {
            console.log(response.status + ": Password verified.");
            return true; // Password verified
        } else {
            showToast('toast-error', 'Incorrect password.');
            console.log(response.status + ": Incorrect password.");
            return false; // Invalid password
        }
    } catch (error) {
        console.error('Error verifying password:', error);
        return false;
    }
}

// Swal Prompt for password
window.promptForPassword = function () {
    return new Promise((resolve) => {
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
                const isValid = await verifyPassword(password);

                if (isValid) {
                    resolve(true); // Password verified
                } else {
                    resolve(false); // Password incorrect
                }
            } else {
                resolve(false); // User canceled the dialog
            }
        });
    });
};