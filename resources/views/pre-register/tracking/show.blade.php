<x-pre-reg-layout>

    <div class="relative">
        <a href="/pre-register/search" class="absolute text-sm/6 font-semibold text-gray-900">Back</a>
    </div>

    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-900">Next Steps to Complete Your Registration</h2>
            <p class="text-gray-600 mt-2">Follow the instructions below to finalize your registration process.</p>
        </div>

        <!-- Instructions Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Confirmation Details Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-800">Your Pre-Registration Details</h3>

                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Pre-Registration Code:
                        <span id="preRegCode" class="text-primary cursor-pointer min-w-fit">
                            {{ $patient->pre_registration_code }}
                            <i class="fas fa-clipboard text-xl"></i>
                        </span>
                    </h3>
                </div>

                <div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
                    </div>
                    <div class="mt-1">
                        <p class="text-gray-600"><strong>Name:</strong> {{ $patient->first_name }} {{ $patient->middle_name ?? '' }} {{ $patient->last_name }}</p>
                        <p class="text-gray-600"><strong>Birthdate:</strong> {{ $patient->birthdate }}</p>
                        <p class="text-gray-600"><strong>Sex:</strong> {{ $patient->sex }} </p>
                        <p class="text-gray-600"><strong>Religion:</strong> {{ $patient->religion }} </p>
                        <p class="text-gray-600"><strong>Civil Status:</strong> {{ $patient->civil_status }} </p>
                        <p class="text-gray-600"><strong>Citizenship:</strong> {{ $patient->citizenship }} </p>
                        <p class="text-gray-600"><strong>Health Card No.:</strong> {{ $patient->healthcard_number ?? 'N/A' }} </p>
                    </div>
                </div>

                <div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-800">Contact Information</h3>
                    </div>
                    <div class="mt-1">
                        <p class="text-gray-600"><strong>Complete Address:</strong> {{ $patient->address }} </p>
                        <p class="text-gray-600"><strong>Email:</strong> {{ $patient->email }} </p>
                        <p class="text-gray-600"><strong>Contact Number:</strong> {{ $patient->contact_number }} </p>
                    </div>
                </div>

                <div>
                    <div class="mt-4 ">
                        <h3 class="text-lg font-semibold text-gray-800">Emergency Contact Information</h3>
                    </div>
                    <div class="mt-1">
                        <p class="text-gray-600"><strong>Name:</strong> {{ $patient->emergency_contact1_name }} </p>
                        <p class="text-gray-600"><strong>Contact Number:</strong> {{ $patient->emergency_contact1_number }} </p>
                        <p class="text-gray-600"><strong>Relationship:</strong> {{ $patient->emergency_contact1_relationship }} </p>
                    </div>
                    <div class="mt-1">
                        <p class="text-gray-600"><strong>Name:</strong> {{ $patient->emergency_contact2_name }} </p>
                        <p class="text-gray-600"><strong>Contact Number:</strong> {{ $patient->emergency_contact2_number }} </p>
                        <p class="text-gray-600"><strong>Relationship:</strong> {{ $patient->emergency_contact2_relationship }} </p>
                    </div>
                </div>
            </div>


            <!-- Next Steps Section -->
            <div class="space-y-6 h-full flex flex-col">
                <!-- Step 1 -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">1. Go to the Nearest Hospital</h3>
                    <p class="text-gray-600 mt-2">Visit the nearest hospital where you initiated the pre-registration process.</p>
                </div>

                <!-- Step 2 -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">2. Show Your Pre-Registration Code</h3>
                    <p class="text-gray-600 mt-2">Upon arrival, provide the hospital staff with your unique Pre-Registration Code. This code confirms your registration.</p>
                </div>

                <!-- Step 3 -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">3. Confirm Your Information</h3>
                    <p class="text-gray-600 mt-2">The hospital staff will verify your details. Please ensure that the information is correct and up-to-date.</p>
                </div>

                <!-- Step 4 -->
                <div class="flex-1 bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">4. Register Your Iris to the System</h3>
                    <p class="text-gray-600 mt-2">For security and identification purposes, you will be asked to register your iris in the hospital's system.</p>
                </div>
            </div>


        </div>

        <!-- Important Notes Section -->
        <div class="mt-6 bg-yellow-50 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-yellow-800">Important Notes</h3>
            <ul class="list-disc list-inside mt-2 text-yellow-700">
                <li>Save your Pre-Registration Code in a safe place. You will need it for confirmation at the hospital.</li>
                <li>Ensure that the details provided during the pre-registration are accurate and complete.</li>
                <li>If any information is incorrect, inform the hospital staff immediately during the confirmation process.</li>
                <li>Bring a valid ID to verify your identity at the hospital.</li>
                <li>Keep this page accessible for your reference.</li>
            </ul>
        </div>
    </div>


    <!-- Copy code to clipboard when clicked -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preRegCode = document.getElementById('preRegCode');

            preRegCode.addEventListener('click', function() {
                const textToCopy = preRegCode.textContent; // Get the text content of the pre-registration code

                // Create a temporary textarea element to copy the text
                const textArea = document.createElement('textarea');
                textArea.value = textToCopy;
                document.body.appendChild(textArea);
                textArea.select(); // Select the text

                // Execute the copy command
                document.execCommand('copy');
                document.body.removeChild(textArea); // Remove the textarea after copying

                // Show a success message (optional)
                Swal.fire({
                    title: 'Success!',
                    text: 'Pre-registration code copied to clipboard.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'bg-primary text-white px-6 py-3', // Button styles
                    }
                });
            });
        });
    </script>

</x-pre-reg-layout>