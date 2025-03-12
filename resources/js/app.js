window.prototype = this;

import "./bootstrap";
import Swal from "sweetalert2";
import "../../vendor/rappasoft/laravel-livewire-tables/resources/imports/laravel-livewire-tables-all.js";

// Function to show success toast
window.showToast = function (toastID, message = "") {
    const toast = document.getElementById(toastID);
    const toastMessage = document.getElementById(toastID + "-message");

    // Set the custom message
    toastMessage.innerText = message;

    // Remove hidden class to make it visible
    toast.classList.remove("hidden");

    // Add animation for sliding down
    toast.classList.add(
        "transition-transform",
        "transform",
        "translate-y-[-100%]"
    ); // Start position (hidden above)

    // Trigger reflow to ensure the animation plays
    void toast.offsetWidth; // This forces a reflow

    // Slide down
    toast.classList.remove("translate-y-[-100%]");
    toast.classList.add("translate-y-0", "duration-300", "ease-out");

    // Hide the toast after 3 seconds with a slide-up animation
    setTimeout(() => {
        hideToast(toastID);
    }, 3000); // Duration before starting to slide up
};

// Function to hide toast (used by the close button)
window.hideToast = function (toastID) {
    const toast = document.getElementById(toastID);
    toast.classList.remove("translate-y-0");
    toast.classList.add("translate-y-[-100%]", "duration-300", "ease-in");

    // After the animation is done, hide it completely
    setTimeout(() => {
        toast.classList.add("hidden");
    }, 300); // Wait for slide-up animation to finish before hiding
};

// Function to validate the form
window.validateForm = async function (formID, fetchURL) {
    // Validate the form
    const form = document.getElementById(formID);
    const formData = new FormData(form);

    // Clear existing error messages
    clearErrorMessages();

    try {
        // Make the fetch request to the validation endpoint
        const response = await fetch(fetchURL, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
            },
        });

        if (response.ok) {
            // If the server responds with 200 OK, assume validation passed
            console.log("Success:", "Form data is validated.");
            return true;
        } else if (response.status === 422) {
            // Handle validation errors (422 Unprocessable Content)
            const errors = await response.json();
            showErrorMessages(errors.errors); // Function to display validation errors
            return false; // Prevent form submission
        } else {
            // Handle other response statuses
            showToast(
                "toast-error",
                "An unexpected error occurred. Please try again later."
            );
            console.error("Unexpected response:", response.status);
            return false;
        }
    } catch (error) {
        // Handle network or other errors
        showToast(
            "toast-error",
            "Failed to validate the form. Please check your connection and try again."
        );
        console.error("Error during form validation:", error);
        return false;
    }
};

window.clearForm = function (formID) {
    const form = document.getElementById(formID);
    form.reset();
    clearErrorMessages();
};

// Helper function to show validation errors
window.showErrorMessages = function (errors) {
    // Clear existing errors
    document
        .querySelectorAll(".error-message")
        .forEach((el) => (el.textContent = ""));

    // Loop through errors and display them next to the relevant fields
    for (const [field, messages] of Object.entries(errors)) {
        const errorElement = document.getElementById(`${field}-error`);
        if (errorElement) {
            errorElement.textContent = messages[0]; // Show the first error message
        }
    }

    showToast(
        "toast-error",
        "Please correct the highlighted errors and try again."
    );
    console.error("Validation errors:", errors);
};

// Clear error messages
window.clearErrorMessages = function () {
    document
        .querySelectorAll(".error-message")
        .forEach((el) => (el.textContent = ""));
};

// Verify the password with the server (make a request to the server to check the password)
window.verifyPassword = async function (password) {
    try {
        const response = await fetch("/verify-password", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                password: password,
            }),
        });

        const result = await response.json();

        if (response.ok && result.success) {
            console.log(response.status, "Password verified.");
            return true; // Password verified
        } else {
            showToast("toast-error", "Incorrect password.");
            console.error(response.status, "Incorrect password.");
            return false; // Invalid password
        }
    } catch (error) {
        console.error("Error verifying password:", error);
        return false;
    }
};

// Swal Prompt for password
window.promptForPassword = function () {
    return new Promise((resolve) => {
        Swal.fire({
            title: "Confirm Your Identity",
            text: "Please enter your password to continue.",
            input: "password",
            inputPlaceholder: "Enter your password",
            showCancelButton: true,
            confirmButtonText: "Verify",
            customClass: {
                confirmButton: "bg-primary text-white px-6 py-3",
                cancelButton: "bg-red-500 text-white px-6 py-3",
                input: "text-center",
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

window.reloadPage = function (time = 0, backToTop = false) {
    if (backToTop) {
        if ("scrollRestoration" in history) {
            history.scrollRestoration = "manual";
        }
    }
    setTimeout(() => {
        location.reload();
    }, time);
};
