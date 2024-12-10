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
                        <a href="{{ route('users.doctor.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Doctors</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="size-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Create</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="max-w-4xl w-full mx-auto">

        <div class="w-full flex flex-col items-center">
            <form method="POST" action="{{ route('users.doctor.store') }}" id="RegistrationForm" class="w-full">
                @csrf
                <div class="bg-white rounded-lg shadow">
                    <!-- Personal Information -->
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Personal Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                            <x-forms.field-container class="sm:col-span-4">
                                <x-forms.label
                                    for="last_name"
                                    :required="true">
                                    Last Name
                                </x-forms.label>

                                <x-forms.input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    :value="old('last_name')"
                                    autocomplete="off" />
                                <x-forms.error name="last_name" />
                            </x-forms.field-container>

                            <x-forms.field-container class="sm:col-span-4">
                                <x-forms.label
                                    for="first_name"
                                    :required="true">
                                    First Name
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
                                    :value="old('middle_name') ?? ''"
                                    autocomplete="off" />
                                <x-forms.error name="middle_name" />
                            </x-forms.field-container>

                            <x-forms.field-container class="sm:col-span-6">
                                <x-forms.label
                                    for="birthdate"
                                    :required="true">
                                    Birthdate
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
                                    Sex
                                </x-forms.label>

                                <x-forms.select
                                    id="sex"
                                    name="sex">
                                    <option {{ old('sex') === null ? 'selected' : '' }} value="">Select</option>
                                    <option value="Male" {{ old('sex') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                                </x-forms.select>
                                <x-forms.error name="sex" />

                            </x-forms.field-container>

                            <x-forms.field-container class="sm:col-span-4">
                                <x-forms.label
                                    for="religion"
                                    :required="true">
                                    Religion
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
                                    for="civil_status"
                                    :required="true">
                                    Civil Status
                                </x-forms.label>

                                <x-forms.select
                                    id="civil_status"
                                    name="civil_status">
                                    <option {{ old('civil_status') === null ? 'selected' : '' }} value="">Select</option>
                                    <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Divorced" {{ old('civil_status') === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                </x-forms.select>
                                <x-forms.error name="civil_status" />
                            </x-forms.field-container>

                            <x-forms.field-container class="sm:col-span-4">
                                <x-forms.label
                                    for="citizenship"
                                    :required="true">
                                    Citizenship
                                </x-forms.label>

                                <x-forms.input
                                    type="text"
                                    id="citizenship"
                                    name="citizenship"
                                    :value="old('citizenship')"
                                    autocomplete="off" />
                                <x-forms.error name="citizenship" />
                            </x-forms.field-container>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Contact Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                            <x-forms.field-container class="sm:col-span-12">
                                <x-forms.label
                                    for="address"
                                    :required="true">
                                    Complete Address
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
                                    for="email"
                                    :required="true">
                                    Email
                                </x-forms.label>

                                <x-forms.input
                                    type="text"
                                    id="email"
                                    name="email"
                                    :value="old('email')"
                                    autocomplete="off" />
                                <x-forms.error name="email" />
                            </x-forms.field-container>

                            <x-forms.field-container class="sm:col-span-6">
                                <x-forms.label
                                    for="contact_number"
                                    :required="true">
                                    Contact Number
                                </x-forms.label>

                                <x-forms.input
                                    type="text"
                                    id="contact_number"
                                    name="contact_number"
                                    :value="old('contact_number')"
                                    maxlength="11"
                                    oninput="restrictLetterInput(this)"
                                    autocomplete="off" />
                                <x-forms.error name="contact_number" />
                            </x-forms.field-container>

                        </div>
                    </div>

                    <!-- Job Information -->
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">Job Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                            <x-forms.field-container class="sm:col-span-6">
                                <x-forms.label
                                    for="type"
                                    :required="true">
                                    Department
                                </x-forms.label>

                                <x-forms.input
                                    type="text"
                                    id="type"
                                    name="type"
                                    :value="old('type')"
                                    autocomplete="off" />
                                <x-forms.error name="type" />
                            </x-forms.field-container>

                            <x-forms.field-container class="sm:col-span-6">
                                <x-forms.label
                                    for="room"
                                    :required="true">
                                    Room
                                </x-forms.label>

                                <x-forms.input
                                    type="text"
                                    id="room"
                                    name="room"
                                    :value="old('room')"
                                    autocomplete="off" />
                                <x-forms.error name="room" />
                            </x-forms.field-container>

                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="p-6">
                        <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
                            <button
                                id="fill"
                                type="button"
                                onclick="fillFields()"
                                class="rounded-md px-3 py-2 text-sm font-semibold text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                                Test
                            </button>

                            <x-forms.primary-button
                                type="button"
                                onclick="confirmCreate()">
                                Submit
                            </x-forms.primary-button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Validation -->
    <script>
        function restrictLetterInput(input) {
            // Allow only numbers and dash "-" (for date format like mm-dd-yyyy)
            input.value = input.value.replace(/[^0-9\-\/]/g, '');
        }
    </script>

    <!-- Confirmation dialog -->
    <script>
        // Confirmation dialog
        async function confirmCreate() {
            // Prevent the default form submission
            event.preventDefault();

            const isFormValidated = await validateForm('RegistrationForm', '/users/doctor/validate-store-request');
            if (isFormValidated) {
                const isVerified = await promptForPassword();
                if (isVerified) {
                    createUser();

                    // redirect to the list of users
                    clearForm('RegistrationForm');
                }
                return;
            }
        }

        // Creation process
        async function createUser() {
            const form = document.getElementById('RegistrationForm');
            const formData = new FormData(form);

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

                if (response.ok) {
                    const result = await response.json();
                    showToast('toast-success', result.message);
                    console.log(response.status, result.message);
                } else {
                    showToast('toast-error', 'Failed to create the account.');
                    console.error(response.status, 'Failed to create the account.');
                }
            } catch (error) {
                showToast('toast-error', 'An error occurred while processing the request.');
                console.error(response.status, error);
            }
        }
    </script>

    <!-- Test -->
    <script>
        function fillFields() {
            // Predefined values for testing
            const testData = {
                first_name: "John",
                middle_name: "James",
                last_name: "Doe",
                email: "john.doe@example.com",
                birthdate: "10-20-1990",
                sex: "Male",
                religion: "Catholic",
                civil_status: "Single",
                citizenship: "Male",

                address: "4527 Colonial Drive High Hill Texas",
                email: "jd.doctor@gmail.com",
                contact_number: "09123456789",

                room: "B102",
                type: "Orthopedic",
            };

            // Fill fields using their IDs
            document.getElementById('first_name').value = testData.first_name;
            document.getElementById('middle_name').value = testData.middle_name;
            document.getElementById('last_name').value = testData.last_name;
            document.getElementById('birthdate').value = testData.birthdate;
            document.getElementById('sex').value = testData.sex;
            document.getElementById('religion').value = testData.religion;
            document.getElementById('civil_status').value = testData.civil_status;
            document.getElementById('citizenship').value = testData.citizenship;

            document.getElementById('address').value = testData.address;
            document.getElementById('email').value = testData.email;
            document.getElementById('contact_number').value = testData.contact_number;

            document.getElementById('type').value = testData.type;
            document.getElementById('room').value = testData.room;

            console.log("Fields filled with test data!");
        }
    </script>

</x-layout>