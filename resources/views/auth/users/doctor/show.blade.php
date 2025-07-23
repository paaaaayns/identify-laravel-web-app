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
                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">{{ $profile->user_id }}</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Left Column -->
        <div class="flex flex-col items-center text-center bg-white shadow rounded-lg md:col-span-1 p-6 self-start">
            <!-- Profile Picture -->
            <div class="w-40 h-40 mb-2">
                <svg class="w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="#1F555F" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <!-- User Info -->
            <h2 class="text-lg font-semibold text-gray-800">{{ $profile->last_name }}, {{ $profile->first_name }} {{ $profile->middle_name ?? '' }}</h2>
            <p class="text-sm text-gray-500">{{ $profile->user_id }}</p>
        </div>

        <!-- Right Column -->
        <div class="space-y-4 md:col-span-3">

            <!-- Personal Information -->
            <div class="bg-white shadow rounded-lg p-6">
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
                            autocomplete="off"
                            disabled />
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
                            autocomplete="off"
                            disabled />
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
                            autocomplete="off"
                            disabled />
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
                            datepicker-format="yyyy-mm-dd"
                            disabled />
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
                            name="sex"
                            disabled>
                            <option disabled {{ $profile->sex === null ? 'selected' : '' }} value="">Select</option>
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
                            autocomplete="off"
                            disabled />
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
                            name="civil_status"
                            disabled>
                            <option disabled {{ $profile->civil_status === null ? 'selected' : '' }} value="">Select</option>
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
                            autocomplete="off"
                            disabled />
                        <x-forms.error name="citizenship" />
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
                            autocomplete="off"
                            disabled />
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
                            autocomplete="off"
                            disabled />
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
                            autocomplete="off"
                            disabled />
                        <x-forms.error name="contact_number" />
                        @endif
                    </x-forms.field-container>

                </div>
            </div>

            <!-- Job Information -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800">Job Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">
                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="type">
                            Specialization
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="type"
                            name="type"
                            :value="$profile->type"
                            autocomplete="off"
                            disabled />
                        <x-forms.error name="type" />
                        @endif
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="license_number">
                            License Number
                        </x-forms.label>
                        <x-forms.input
                            type="text"
                            id="license_number"
                            name="license_number"
                            :value="$profile->license_number"
                            autocomplete="off"
                            disabled />
                        <x-forms.error name="license_number" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-4">
                        <x-forms.label
                            for="room">
                            Room
                        </x-forms.label>

                        @if (true)
                        <x-forms.input
                            type="text"
                            id="room"
                            name="room"
                            :value="$profile->room"
                            autocomplete="off"
                            disabled />
                        <x-forms.error name="room" />
                        @endif
                    </x-forms.field-container>
                </div>
            </div>
        </div>
    </div>

</x-layout>