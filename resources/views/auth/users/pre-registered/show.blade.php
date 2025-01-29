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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Left Column -->
        <div class="space-y-4 md:col-span-1">
            <div class="flex flex-col items-center text-center bg-white shadow rounded-lg p-6 self-start">
                <!-- Profile Picture -->
                <div class="w-32 h-32 mb-4">
                    <!-- $profile->ulid is the folder name, get the first image as the source of the image tag make it dynamic -->
                    <img src="{{ Storage::url($profile->ulid . '/biometrics/face.png') }}" alt="Profile Picture" class="w-full h-full rounded-full shadow">
                </div>
                <!-- User Info -->
                <h2 class="text-lg font-semibold text-gray-800">{{ $profile->first_name }} {{ $profile->middle_name ?? '' }} {{ $profile->last_name }}</h2>
                <p class="text-sm text-gray-500">{{ $profile->user_id }}</p>
            </div>

            <div class="grid grid-cols-1 text-center bg-white shadow rounded-lg gap-y-6 p-6 self-start">

                @role(['admin'])
                <div class="">
                    <x-forms.primary-button
                        type="submit"
                        form="RegistrationForm"
                        class="w-full">
                        Override Registration
                    </x-forms.primary-button>
                </div>
                @endrole

                <div class="">
                    <x-forms.primary-button
                        class="w-full"
                        type="button"
                        onclick="confirmCreate()">
                        Complete Registration
                    </x-forms.primary-button>
                </div>

                <div class="">
                    <x-forms.primary-button
                        type="button"
                        onclick="openModal()"
                        data-modal-target="camera-modal"
                        class="w-full">
                        Capture Iris
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

                    <x-forms.field-container class="sm:col-span-4 grid place-items-center">
                        <x-forms.label for="address">
                            Right Iris
                        </x-forms.label>

                        <div class="w-48 h-48 rounded-lg shadow overflow-hiddent">
                            <img
                                src="{{ Storage::url($profile->ulid . '/biometrics/right_iris.png') }}"
                                alt="Right Iris"
                                class="w-full h-full object-cover">
                        </div>
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4 grid place-items-center">
                        <x-forms.label for="email">
                            Face
                        </x-forms.label>

                        <div class="w-48 h-48 rounded-lg shadow overflow-hidden">
                            <img
                                src="{{ Storage::url($profile->ulid . '/biometrics/face.png') }}"
                                alt="Face"
                                class="w-full h-full object-cover">
                        </div>
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4 grid place-items-center">
                        <x-forms.label for="contact_number">
                            Left Iris
                        </x-forms.label>

                        <div class="w-48 h-48 rounded-lg shadow overflow-hidden">
                            <img
                                src="{{ Storage::url($profile->ulid . '/biometrics/left_iris.png') }}"
                                alt="Left Iris"
                                class="w-full h-full object-cover">
                        </div>
                    </x-forms.field-container>

                </div>
            </div>
        </form>
    </div>

    <!-- Main modal -->
    <div
        id="camera-modal"
        onclick="handleModalBackgroundClick(event)"
        tabindex="-1"
        aria-hidden="true"
        class="hidden bg-gray-800 bg-opacity-75 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-center items-center p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Look at the camera
                    </h3>
                </div>
                <!-- Modal Body -->
                <div class="p-4">
                    <video id="video" class="w-full bg-gray-300 rounded-md" autoplay></video>
                    <canvas id="canvas" class="hidden"></canvas>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-center items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button
                        onclick="captureImage()"
                        data-modal-hide="camera-modal"
                        type="button"
                        class="text-white bg-primary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Capture
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script defer>
        let videoStream;

        function openModal() {
            const modal = document.getElementById('camera-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            openCamera();
        }

        async function openCamera() {
            // Start the camera
            const video = document.getElementById('video');
            videoStream = await navigator.mediaDevices.getUserMedia({
                video: true
            });
            video.srcObject = videoStream;
            video.play();
        }

        function closeCamera() {
            // Stop the camera
            if (videoStream) {
                const tracks = videoStream.getTracks();
                tracks.forEach(track => track.stop());
            }
        }

        function handleModalBackgroundClick(event) {
            const modal = document.getElementById('camera-modal');
            if (event.target === modal) {
                closeCamera();
            }
        }

        function captureImage() {
            const canvas = document.getElementById('canvas');
            const video = document.getElementById('video');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Convert the canvas image to Base64
            const imageData = canvas.toDataURL('image/png');

            // Send the image to the server
            fetch('/biometrics/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        image: imageData,
                        patient: '{{ $profile->ulid }}',
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('toast-success', data.message);
                        console.log('Image URL:', data.path);
                        closeCamera();
                    } else {
                        showToast('toast-error', data.message);
                        alert('Error storing image.');
                        closeCamera();
                    }
                })
                .catch(error => {
                    showToast('toast-error', 'An error occurred while storing the image.');
                    console.error('Error:', error);
                    closeCamera();
                });
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
                const isVerified = await promptForPassword();
                if (isVerified) {
                    const user = await createUser();
                    if (user) {
                        // redirect to the users.patient.show with ulid
                        window.location.href = `/users/patient/${user.ulid}`;
                    }
                }
                return;
            }
        }

        // Creation process
        async function createUser() {
            const form = document.getElementById('RegistrationForm');
            const formData = new FormData(form);

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