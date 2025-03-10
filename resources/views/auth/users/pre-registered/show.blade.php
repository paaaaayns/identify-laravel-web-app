<x-layout>

    <div class="flex mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <div>
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="size-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">Home</span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="size-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Users</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="size-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('users.pre-reg.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Pre-Registered Patients</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="size-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">{{ $profile->user_id }}</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Left Column -->
        <div class="space-y-4 md:col-span-1">
            <div class="flex flex-col items-center text-center bg-white shadow rounded-lg p-6 self-start">
                <!-- Profile Picture -->
                <div class="w-32 h-32 mb-4">
                    <!-- $profile->ulid is the folder name, get the first image as the source of the image tag make it dynamic -->
                    <img
                        id="profile_picture"
                        alt="Profile Picture"
                        class="w-full h-full rounded-full shadow">
                </div>
                <!-- User Info -->
                <h2 class="text-lg font-semibold text-gray-800">{{ $profile->first_name }} {{ $profile->middle_name ?? '' }} {{ $profile->last_name }}</h2>
                <p class="text-sm text-gray-500">{{ $profile->user_id }}</p>
            </div>

            <div class="grid grid-cols-1 text-center bg-white shadow rounded-lg gap-y-6 p-6 self-start">
                <div class="">
                    <x-forms.primary-button
                        class="w-full"
                        type="button"
                        onclick="confirmCreate()">
                        Complete Registration
                    </x-forms.primary-button>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <form
            id="RegistrationForm"
            method="POST"
            action="{{ route('users.patient.store') }}"
            class="space-y-4 md:col-span-3">
            @csrf

            <input type="hidden" name="ulid" value="{{ $profile->ulid }}">
            <input type="hidden" name="pre_registration_code" value="{{ $profile->pre_registration_code }}">

            <!-- Personal Information -->
            <div class="bg-white shadow rounded-lg p-6 !mt-0">
                <h3 class="text-xl font-semibold text-gray-800">Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="last_name">
                            Last Name
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="last_name"
                            name="last_name"
                            :value="$profile->last_name"
                            autocomplete="off" />
                        <x-forms.error name="last_name" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="first_name">
                            First Name
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="first_name"
                            name="first_name"
                            :value="$profile->first_name"
                            autocomplete="off" />
                        <x-forms.error name="first_name" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="middle_name">
                            Middle Name
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="middle_name"
                            name="middle_name"
                            :value="$profile->middle_name ?? ''"
                            autocomplete="off" />
                        <x-forms.error name="middle_name" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="birthdate">
                            Birthdate
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="birthdate"
                            name="birthdate"
                            :value="$profile->birthdate"
                            autocomplete="off"
                            oninput="restrictLetterInput(this)"
                            datepicker
                            datepicker-autohide
                            datepicker-format="yyyy-mm-dd" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="sex">
                            Sex
                        </x-forms.label>

                        @if (true)
                        <x-forms.select
                            id="sex"
                            name="sex">
                            <option {{ $profile->sex === null ? 'selected' : '' }} value="">Select</option>
                            <option value="Male" {{ $profile->sex === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $profile->sex === 'Female' ? 'selected' : '' }}>Female</option>
                        </x-forms.select>
                        <x-forms.error name="sex" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="religion">
                            Religion
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="religion"
                            name="religion"
                            :value="$profile->religion"
                            autocomplete="off" />
                        <x-forms.error name="religion" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="civil_status">
                            Civil Status
                        </x-forms.label>

                        @if (true)
                        <x-forms.select
                            id="civil_status"
                            name="civil_status">
                            <option {{ $profile->civil_status === null ? 'selected' : '' }} value="">Select</option>
                            <option value="Single" {{ $profile->civil_status === 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ $profile->civil_status === 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Divorced" {{ $profile->civil_status === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        </x-forms.select>
                        <x-forms.error name="civil_status" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="citizenship">
                            Citizenship
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="citizenship"
                            name="citizenship"
                            :value="$profile->citizenship"
                            autocomplete="off" />
                        <x-forms.error name="citizenship" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="healthcard_number">
                            Health Card No.
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="healthcard_number"
                            name="healthcard_number"
                            :value="$profile->healthcard_number ?? 'N/A'"
                            autocomplete="off" />
                        <x-forms.error name="healthcard_number" />
                        @endif
                    </x-forms.field-container>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800">Contact Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                    <x-forms.field-container class="sm:col-span-12">
                        <x-forms.label
                            for="address">
                            Complete Address
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="address"
                            name="address"
                            :value="$profile->address"
                            autocomplete="off" />
                        <x-forms.error name="address" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="email">
                            Email
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="email"
                            name="email"
                            :value="$profile->email"
                            autocomplete="off" />
                        <x-forms.error name="email" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6">
                        <x-forms.label
                            for="contact_number">
                            Contact Number
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="contact_number"
                            name="contact_number"
                            :value="$profile->contact_number"
                            autocomplete="off" />
                        <x-forms.error name="contact_number" />
                        @endif
                    </x-forms.field-container>

                </div>
            </div>

            <!-- Emergency Contact Information -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800">Emergency Contact Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="emergency_contact1_name">
                            Name
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="emergency_contact1_name"
                            name="emergency_contact1_name"
                            :value="$profile->emergency_contact1_name"
                            autocomplete="off" />
                        <x-forms.error name="emergency_contact1_name" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="emergency_contact1_relationship">
                            Relationship
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="emergency_contact1_relationship"
                            name="emergency_contact1_relationship"
                            :value="$profile->emergency_contact1_relationship"
                            autocomplete="off" />
                        <x-forms.error name="emergency_contact1_relationship" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="emergency_contact1_number">
                            Contact Number
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="emergency_contact1_number"
                            name="emergency_contact1_number"
                            :value="$profile->emergency_contact1_number"
                            autocomplete="off" />
                        <x-forms.error name="emergency_contact1_number" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="emergency_contact2_name">
                            Name
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="emergency_contact2_name"
                            name="emergency_contact2_name"
                            :value="$profile->emergency_contact2_name"
                            autocomplete="off" />
                        <x-forms.error name="emergency_contact2_name" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="emergency_contact2_relationship">
                            Relationship
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="emergency_contact2_relationship"
                            name="emergency_contact2_relationship"
                            :value="$profile->emergency_contact2_relationship"
                            autocomplete="off" />
                        <x-forms.error name="emergency_contact2_relationship" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="emergency_contact2_number">
                            Contact Number
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="emergency_contact2_number"
                            name="emergency_contact2_number"
                            :value="$profile->emergency_contact2_number"
                            autocomplete="off" />
                        <x-forms.error name="emergency_contact2_number" />
                        @endif
                    </x-forms.field-container>

                </div>
            </div>

            <!-- Biometric Information -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800">Biometric Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                    <x-forms.field-container class="sm:col-span-6 grid place-items-center">
                        <x-forms.label for="right_iris">
                            Right Iris
                        </x-forms.label>

                        <!-- Hidden File Input -->
                        <input
                            type="file"
                            id="right_iris"
                            name="right_iris"
                            accept="image/*"
                            class="hidden"
                            onchange="previewIris(event, 'right_iris', 'right_iris_preview', 'right_iris_text')">
                        <x-forms.error name="right_iris" />

                        <!-- Upload Box -->
                        <label
                            for="right_iris"
                            class="cursor-pointer w-80 h-80 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg shadow text-gray-500 hover:border-primary hover:text-primary overflow-hidden">
                            <span id="right_iris_text">Click to upload an image</span>
                            <img id="right_iris_preview" alt="Right Iris" class="hidden w-full h-full object-cover">
                        </label>
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-6 grid place-items-center">
                        <x-forms.label for="left_iris">
                            Left Iris
                        </x-forms.label>

                        <!-- Hidden File Input -->
                        <input
                            type="file"
                            id="left_iris"
                            name="left_iris"
                            accept="image/*"
                            class="hidden"
                            onchange="previewIris(event, 'left_iris', 'left_iris_preview', 'left_iris_text')">
                        <x-forms.error name="left_iris" class="!mt-0 !mb-4" />

                        <!-- Upload Box -->
                        <label
                            for="left_iris"
                            class="cursor-pointer w-80 h-80 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg shadow text-gray-500 hover:border-primary hover:text-primary overflow-hidden">
                            <span id="left_iris_text">Click to upload an image</span>
                            <img id="left_iris_preview" alt="Left Iris" class="hidden w-full h-full object-cover">
                        </label>
                    </x-forms.field-container>

                </div>
            </div>
        </form>
    </div>

    <!-- Iris Preview Script -->
    <script>
        function previewIris(event, input_id, image_id, text_id) {
            const file = event.target.files[0];
            const preview = document.getElementById(image_id);
            const uploadText = document.getElementById(text_id);

            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    preview.src = reader.result;
                    preview.classList.remove('hidden');
                    uploadText.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

    <script>
        function restrictLetterInput(input) {
            input.value = input.value.replace(/[^0-9\-]/g, '');
        }
    </script>

    <script>
        // Confirmation dialog
        async function confirmCreate() {
            // Prevent the default form submission
            event.preventDefault();

            const isFormValidated = await validateForm('RegistrationForm', '/users/patient/validate-store-request');
            if (isFormValidated) {
                const user = await createUser();
                if (user) {
                    // redirect to the users.patient.show with ulid
                    window.location.href = `/users/patient/${user.ulid}`;
                }
                return;
            }
        }

        // Creation process
        async function createUser() {
            const form = document.getElementById('RegistrationForm');
            const formData = new FormData(form);

            // Convert images to Base64
            const rightIrisFile = document.getElementById('right_iris').files[0];
            const leftIrisFile = document.getElementById('left_iris').files[0];

            console.log('Form data:', formData);

            try {
                // Perform the POST request using Fetch API
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });

                const result = await response.json();

                if (response.ok) {
                    showToast('toast-success', result.message);
                    console.log(response.status, result.message);
                    console.log('User:', result.user);

                    // Return user data
                    return result.user;
                } else {
                    showToast('toast-error', result.message);
                    console.error(response.status, result.message);
                    return null;
                }
            } catch (error) {
                showToast('toast-error', 'An error occurred while processing the request.');
                console.error('Fetch error:', error);
                return null;
            }
        }
    </script>

</x-layout>