<div
    x-data="profileFormHandler()"
    class="space-y-4">

    <!-- Toggle Edit Mode -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Edit Mode</h3>

            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    x-model="editMode"
                    @click="toggleEditMode()"
                    class="sr-only peer">
                <div class="relative w-11 h-6 bg-gray-300 rounded-full 
                    peer peer-checked:bg-primary 
                    peer-focus:ring-0 peer-focus:ring-primary-hover 
                    peer-checked:after:translate-x-full peer-checked:after:border-white 
                    after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all">
                </div>
            </label>
        </div>
    </div>

    <form
        id="UpdateProfileForm"
        method="POST"
        action="{{ route('users.updateProfile', $profile->user_id) }}"
        class="grid grid-cols-1 gap-y-6 bg-white p-6 rounded-lg shadow">
        <!-- Personal Information -->
        <div class="grid grid-cols-1 gap-y-6">
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-800">Personal Information</h3>
            <!-- Fields -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6">
                <x-forms.field-container class="sm:col-span-4">
                    <x-forms.label
                        for="first_name">
                        First Name
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="first_name"
                        name="first_name"
                        :value="$profile->first_name"
                        autocomplete="off"
                        disabled />
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
                        :value="$profile->middle_name ?? ''"
                        autocomplete="off"
                        disabled />
                    <x-forms.error name="middle_name" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-4">
                    <x-forms.label
                        for="last_name">
                        Last Name
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="last_name"
                        name="last_name"
                        :value="$profile->last_name"
                        autocomplete="off"
                        disabled />
                    <x-forms.error name="last_name" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="birthdate">
                        Birthdate
                    </x-forms.label>
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
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="sex">
                        Sex
                    </x-forms.label>
                    <x-forms.select
                        id="sex"
                        name="sex"
                        disabled>
                        <option disabled value="" {{ $profile->sex === null ? 'selected' : '' }}>Select</option>
                        <option value="Male" {{ $profile->sex === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $profile->sex === 'Female' ? 'selected' : '' }}>Female</option>
                    </x-forms.select>
                    <x-forms.error name="sex" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-4">
                    <x-forms.label
                        for="religion">
                        Religion
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="religion"
                        name="religion"
                        :value="$profile->religion"
                        autocomplete="off"
                        x-model="form.religion"
                        :disabled="true" x-bind:disabled="!editMode" />
                    <x-forms.error name="religion" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-4">
                    <x-forms.label
                        for="civil_status">
                        Civil Status
                    </x-forms.label>
                    <x-forms.select
                        id="civil_status"
                        name="civil_status"
                        x-model="form.civil_status"
                        :disabled="true" x-bind:disabled="!editMode">
                        <option disabled value="" {{ $profile->civil_status === null ? 'selected' : '' }}>Select</option>
                        <option value="Single" {{ $profile->civil_status === 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ $profile->civil_status === 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Divorced" {{ $profile->civil_status === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                    </x-forms.select>
                    <x-forms.error name="civil_status" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-4">
                    <x-forms.label
                        for="citizenship">
                        Citizenship
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="citizenship"
                        name="citizenship"
                        :value="$profile->citizenship"
                        autocomplete="off"
                        x-model="form.citizenship"
                        :disabled="true" x-bind:disabled="!editMode" />
                    <x-forms.error name="citizenship" />
                </x-forms.field-container>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="grid grid-cols-1 gap-y-6">
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-800">Contact Information</h3>
            <!-- Fields -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6">
                <x-forms.field-container class="sm:col-span-12">
                    <x-forms.label
                        for="address">
                        Complete Address
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="address"
                        name="address"
                        :value="$profile->address"
                        autocomplete="off"
                        x-model="form.address"
                        :disabled="true" x-bind:disabled="!editMode" />
                    <x-forms.error name="address" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="email">
                        Email
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="email"
                        name="email"
                        :value="$profile->email"
                        autocomplete="off"
                        disabled />
                    <x-forms.error name="email" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="contact_number">
                        Contact Number
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="contact_number"
                        name="contact_number"
                        :value="$profile->contact_number"
                        autocomplete="off"
                        x-model="form.contact_number"
                        :disabled="true" x-bind:disabled="!editMode" />
                    <x-forms.error name="contact_number" />
                </x-forms.field-container>
            </div>
        </div>

        <!-- Job Information -->
        <div class="grid grid-cols-1 gap-y-6">
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-800">Job Information</h3>
            <!-- Fields -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6">
                <x-forms.field-container class="sm:col-span-4">
                    <x-forms.label
                        for="type">
                        Specialization
                    </x-forms.label>
                    <x-forms.input
                        type="text"
                        id="type"
                        name="type"
                        :value="$profile->type"
                        autocomplete="off"
                        disabled />
                    <x-forms.error name="type" />
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
                    <x-forms.input
                        type="text"
                        id="room"
                        name="room"
                        :value="$profile->room"
                        autocomplete="off"
                        disabled />
                    <x-forms.error name="room" />
                </x-forms.field-container>
            </div>
        </div>

        <!-- Actions -->
        <div
            x-show="editMode"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="action-buttons">
            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
                <x-forms.primary-button
                    type="button"
                    onclick="updateProfile(event, '{{ Auth::user()->user_id }}', '{{ Auth::user()->role }}')">
                    Save
                </x-forms.primary-button>
            </div>
        </div>
    </form>
</div>

<script>
    function profileFormHandler() {
        return {
            editMode: false,
            original: {
                religion: "{{ $profile->religion }}",
                civil_status: "{{ $profile->civil_status }}",
                citizenship: "{{ $profile->citizenship }}",

                address: "{{ $profile->address }}",
                email: "{{ $profile->email }}",
                contact_number: "{{ $profile->contact_number }}",

                type: "{{ $profile->type }}",
            },
            form: {
                religion: "{{ $profile->religion }}",
                civil_status: "{{ $profile->civil_status }}",
                citizenship: "{{ $profile->citizenship }}",

                address: "{{ $profile->address }}",
                email: "{{ $profile->email }}",
                contact_number: "{{ $profile->contact_number }}",

                type: "{{ $profile->type }}",
            },
            toggleEditMode() {
                this.editMode = !this.editMode;
                if (!this.editMode) {
                    this.form = {
                        ...this.original
                    };
                }
            }
        }
    }
</script>