<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <!-- SweelAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="h-screen flex">
    <!-- Left Division -->
    <div class="fixed inset-y-0 w-1/3 z-50 hidden sm:flex flex-col items-center justify-center bg-background-dark text-white">
        <h1 class="text-2xl">Left Side Content</h1>
    </div>

    <!-- Right Division -->
    <div class="bg-background-light sm:ml-auto w-full sm:w-2/3 pl-4 overflow-y-auto py-10 px-4 sm:px-6 lg:px-10">
        <div class="space-y-0">

            <div class="mx-4 mb-6">
                <a href="/login" class="text-sm/6 font-semibold text-gray-900">Back</a>
            </div>

            <form method="POST" action="{{ route('pre-reg.create') }}" id="PreRegistrationForm">
                @csrf


                <!-- Personal Information -->
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-4">
                    <div class="px-4 pt-6 sm:pt-8 hidden sm:block">
                        <h2 class="text-base/7 font-semibold text-gray-900">Personal Information</h2>
                        <p class="mt-1 text-sm/6 text-gray-600">Please provide your personal details so we can register you properly.</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 md:col-span-3
                        rounded-xl rounded-bl-none rounded-br-none">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:gap-y-8 sm:grid-cols-12">
                                <div class="block sm:hidden">
                                    <h2 class="text-base/7 font-semibold text-gray-900">Personal Information</h2>
                                    <p class="mt-1 text-sm/6 text-gray-600">Please provide your personal details so we can register you properly.</p>
                                </div>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="first_name">
                                        First Name <span class="text-red-500">*</span>
                                    </x-forms.label>
                                    <x-forms.input
                                        type="text"
                                        id="first_name"
                                        name="first_name"
                                        :value="old('first_name')"
                                        autocomplete="off" />

                                    <x-forms.error name="first_name" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="middle_name">
                                        Middle Name
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="middle_name"
                                        name="middle_name"
                                        :value="old('middle_name')"
                                        autocomplete="off" />

                                    <x-forms.error name="middle_name" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="last_name">
                                        Last Name <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="last_name"
                                        name="last_name"
                                        :value="old('last_name')"
                                        autocomplete="off" />

                                    <x-forms.error name="last_name" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-6">
                                    <x-forms.label
                                        for="birthdate">
                                        Birthdate <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="birthdate"
                                        name="birthdate"
                                        :value="old('birthdate')"
                                        autocomplete="off"
                                        oninput="restrictLetterInput(this)"
                                        datepicker
                                        datepicker-autohide
                                        datepicker-format="mm-dd-yyyy" />

                                    <x-forms.error name="birthdate" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-6">
                                    <x-forms.label
                                        for="sex">
                                        Sex <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.select
                                        id="sex"
                                        name="sex">
                                        <option disabled {{ old('sex') === null ? 'selected' : '' }} value="">Select</option>
                                        <option value="Male" {{ old('sex') === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                                    </x-forms.select>

                                    <x-forms.error name="sex" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="religion">
                                        Religion <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="religion"
                                        name="religion"
                                        :value="old('religion')"
                                        autocomplete="off" />

                                    <x-forms.error name="religion" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="civil_status">
                                        Civil Status <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.select
                                        id="civil_status"
                                        name="civil_status">
                                        <option disabled {{ old('civil_status') === null ? 'selected' : '' }} value="">Select</option>
                                        <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Divorced" {{ old('civil_status') === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    </x-forms.select>

                                    <x-forms.error name="civil_status" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="citizenship">
                                        Citizenship <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="citizenship"
                                        name="citizenship"
                                        :value="old('citizenship')"
                                        autocomplete="off" />

                                    <x-forms.error name="citizenship" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="healthcard_number">
                                        Health Card No.
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="healthcard_number"
                                        name="healthcard_number"
                                        :value="old('healthcard_number')"
                                        autocomplete="off" />

                                    <x-forms.error name="healthcard_number" />
                                </x-forms.field-container>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Contact Information -->
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-4">
                    <div class="px-4 pt-6 sm:pt-8 hidden sm:block">
                        <h2 class="text-base/7 font-semibold text-gray-900">Contact Information</h2>
                        <p class="mt-1 text-sm/6 text-gray-600">Enter your contact details so we can reach you if needed.</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 md:col-span-3
                    rounded-none">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:gap-y-8 sm:grid-cols-12">
                                <div class="block sm:hidden">
                                    <h2 class="text-base/7 font-semibold text-gray-900">Contact Information</h2>
                                    <p class="mt-1 text-sm/6 text-gray-600">Enter your contact details so we can reach you if needed.</p>
                                </div>
                                <x-forms.field-container class="sm:col-span-12">
                                    <x-forms.label
                                        for="address">
                                        Complete Address <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="address"
                                        name="address"
                                        :value="old('address')"
                                        autocomplete="off" />

                                    <x-forms.error name="address" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-6">
                                    <x-forms.label
                                        for="email">
                                        Email <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="email"
                                        id="email"
                                        name="email"
                                        :value="old('email')"
                                        autocomplete="off" />

                                    <x-forms.error name="email" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-6">
                                    <x-forms.label
                                        for="contact_number">
                                        Contact Number <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="contact_number"
                                        name="contact_number"
                                        :value="old('contact_number')"
                                        maxlength="11"
                                        autocomplete="off"
                                        oninput="restrictLetterInput(this)" />

                                    <x-forms.error name="contact_number" />
                                </x-forms.field-container>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Emergency Contact Information -->
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-4">
                    <div class="px-4 pt-6 sm:pt-8 hidden sm:block">
                        <h2 class="text-base/7 font-semibold text-gray-900">Emergency Contact Information</h2>
                        <p class="mt-1 text-sm/6 text-gray-600">Provide emergency contact details in case of urgent situations.</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 md:col-span-3
                    rounded-none">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:gap-y-8 sm:grid-cols-12">
                                <div class="block sm:hidden">
                                    <h2 class="text-base/7 font-semibold text-gray-900">Emergency Contact Information</h2>
                                    <p class="mt-1 text-sm/6 text-gray-600">Provide emergency contact details in case of urgent situations.</p>
                                </div>
                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="emergency_contact1_name">
                                        Name <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="emergency_contact1_name"
                                        name="emergency_contact1_name"
                                        :value="old('emergency_contact1_name')"
                                        autocomplete="off" />

                                    <x-forms.error name="emergency_contact1_name" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="emergency_contact1_number">
                                        Contact Number <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="emergency_contact1_number"
                                        name="emergency_contact1_number"
                                        :value="old('emergency_contact1_number')"
                                        autocomplete="off"
                                        maxlength="11"
                                        oninput="restrictLetterInput(this)" />

                                    <x-forms.error name="emergency_contact1_number" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="emergency_contact1_relationship">
                                        Relationship <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="emergency_contact1_relationship"
                                        name="emergency_contact1_relationship"
                                        :value="old('emergency_contact1_relationship')"
                                        autocomplete="off" />

                                    <x-forms.error name="emergency_contact1_relationship" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="emergency_contact2_name">
                                        Name <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="emergency_contact2_name"
                                        name="emergency_contact2_name"
                                        :value="old('emergency_contact2_name')"
                                        autocomplete="off" />

                                    <x-forms.error name="emergency_contact2_name" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="emergency_contact2_number">
                                        Contact Number <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="emergency_contact2_number"
                                        name="emergency_contact2_number"
                                        :value="old('emergency_contact2_number')"
                                        autocomplete="off"
                                        maxlength="11"
                                        oninput="restrictLetterInput(this)" />

                                    <x-forms.error name="emergency_contact2_number" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-4">
                                    <x-forms.label
                                        for="emergency_contact2_relationship">
                                        Relationship <span class="text-red-500">*</span>
                                    </x-forms.label>

                                    <x-forms.input
                                        type="text"
                                        id="emergency_contact2_relationship"
                                        name="emergency_contact2_relationship"
                                        :value="old('emergency_contact2_relationship')"
                                        autocomplete="off" />

                                    <x-forms.error name="emergency_contact2_relationship" />
                                </x-forms.field-container>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Agreement and Consent -->
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-4">
                    <div class="px-4 pt-6 sm:pt-8 hidden sm:block">
                        <h2 class="text-base/7 font-semibold text-gray-900">Agreement and Consent</h2>
                        <p class="mt-1 text-sm/6 text-gray-600">By checking the boxes, you confirm your agreement to our terms and policies.</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 md:col-span-3
                    rounded-xl rounded-tl-none rounded-tr-none 
                    border-t-1 border-gray-900/10">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:gap-y-8 sm:grid-cols-12">
                                <div class="block sm:hidden">
                                    <h2 class="text-base/7 font-semibold text-gray-900">Agreement and Consent</h2>
                                    <p class="mt-1 text-sm/6 text-gray-600">By checking the boxes, you confirm your agreement to our terms and policies.</p>
                                </div>

                                <x-forms.field-container class="sm:col-span-12">
                                    <x-forms.checkbox
                                        type="checkbox"
                                        id="terms_and_conditions"
                                        name="terms_and_conditions" />

                                    <label
                                        for="terms_and_conditions"
                                        class="ms-2 text-sm font-medium text-gray-900">
                                        I agree with the <a href="#" class="text-primary hover:underline">Terms and Conditions</a>.
                                    </label>

                                    <x-forms.error name="terms_and_conditions" />
                                </x-forms.field-container>

                                <x-forms.field-container class="sm:col-span-12">
                                    <x-forms.checkbox
                                        type="checkbox"
                                        id="privacy_policy"
                                        name="privacy_policy" />

                                    <label
                                        for="privacy_policy"
                                        class="ms-2 text-sm font-medium text-gray-900">
                                        I agree with the <a href="#" class="text-primary hover:underline">Privacy Policy</a>.
                                    </label>

                                    <x-forms.error name="privacy_policy" />
                                </x-forms.field-container>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                            <!-- <button type="button" class="rounded-md px-3 py-2 text-sm font-semibold text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">Cancel</button> -->
                            <x-forms.primary-button type="submit">
                                Submit
                            </x-forms.primary-button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>



    <script>
        function restrictLetterInput(input) {
            // Allow only numbers and dash "-" (for date format like mm-dd-yyyy)
            input.value = input.value.replace(/[^0-9\-\/]/g, '');
        }
    </script>


    <!-- Flowbite/Tailwind -->
    <!-- <script>
        document.querySelector('#PreRegistrationForm').addEventListener('submit', async (e) => {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(e.target);

            try {
                const response = await fetch(e.target.action, {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    // Show the success modal
                    const modalToggle = document.querySelector('[data-modal-target="success-modal"]');
                    modalToggle.click();

                    // Redirect to login page on confirmation
                    document.getElementById('confirmButton').addEventListener('click', () => {
                        window.location.href = result.redirect || '/login'; // Default to /login if no redirect is provided
                    });
                } else {
                    console.error(result.message); // Handle validation or server-side errors
                }
            } catch (error) {
                console.error('An error occurred:', error);
            }
        });
    </script> -->


    <!-- Swal2 -->
    <script>
        const form = document.querySelector('#PreRegistrationForm');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            console.log(formData);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                console.log(response);
                const result = await response.json();
                console.log(result);


                if (result.success) {
                    Swal.fire({
                        title: 'Pre-registration Successful!',
                        text: 'You have successfully pre-registered. Click OK to view further instructions.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-primary text-white px-6 py-3', // Button styles
                        },
                    }).then(() => {
                        // window.location.href = "{{ route('login') }}"; // Redirect to login page
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'An error occurred. Please try again.',
                        icon: 'error',
                    });
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again later.',
                    icon: 'error',
                });
            }
        });
    </script>
</body>


<!-- <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
    <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
    <button type="submit" class="rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">Save</button>
</div> -->

</html>