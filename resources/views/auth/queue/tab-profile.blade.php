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
                :value="$patient->last_name"
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
                :value="$patient->first_name"
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
                :value="$patient->middle_name ?? 'N/A'"
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
                :value="$patient->birthdate"
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
                <option disabled {{ $patient->sex === null ? 'selected' : '' }} value="">Select</option>
                <option value="Male" {{ $patient->sex === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $patient->sex === 'Female' ? 'selected' : '' }}>Female</option>
            </x-forms.select>
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
                :value="$patient->religion"
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
                <option disabled {{ $patient->civil_status === null ? 'selected' : '' }} value="">Select</option>
                <option value="Single" {{ $patient->civil_status === 'Single' ? 'selected' : '' }}>Single</option>
                <option value="Married" {{ $patient->civil_status === 'Married' ? 'selected' : '' }}>Married</option>
                <option value="Divorced" {{ $patient->civil_status === 'Divorced' ? 'selected' : '' }}>Divorced</option>
            </x-forms.select>
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
                :value="$patient->citizenship"
                autocomplete="off"
                disabled />
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
                :value="$patient->healthcard_number ?? 'N/A'"
                autocomplete="off"
                disabled />
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
                :value="$patient->address"
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
                :value="$patient->email"
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
                :value="$patient->contact_number"
                autocomplete="off"
                disabled />
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
                :value="$patient->emergency_contact1_name"
                autocomplete="off"
                disabled />
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
                :value="$patient->emergency_contact1_relationship"
                autocomplete="off"
                disabled />
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
                :value="$patient->emergency_contact1_number"
                autocomplete="off"
                disabled />
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
                :value="$patient->emergency_contact2_name"
                autocomplete="off"
                disabled />
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
                :value="$patient->emergency_contact2_relationship"
                autocomplete="off"
                disabled />
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
                :value="$patient->emergency_contact2_number"
                autocomplete="off"
                disabled />
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

            <div class="w-80 h-80 rounded-lg shadow overflow-hidden">
                <img
                    id="right_iris"
                    alt="Right Iris"
                    class="w-full h-full object-cover">
            </div>
        </x-forms.field-container>

        <x-forms.field-container class="sm:col-span-6 grid place-items-center">
            <x-forms.label for="left_iris">
                Left Iris
            </x-forms.label>

            <div class="w-80 h-80 rounded-lg shadow overflow-hidden">
                <img
                    id="left_iris"
                    alt="Left Iris"
                    class="w-full h-full object-cover">
            </div>
        </x-forms.field-container>
    </div>
</div>

<script>
    // on page load
    window.addEventListener('DOMContentLoaded', (event) => {
        // display images to img
            document.getElementById('profile_picture').src = "{{ Storage::url('patients/' . $patient->ulid . '/biometrics/face.png') }}";
            document.getElementById('left_iris').src = "{{ Storage::url('patients/' . $patient->ulid . '/biometrics/left_iris.png') }}";
            document.getElementById('right_iris').src = "{{ Storage::url('patients/' . $patient->ulid . '/biometrics/right_iris.png') }}";
    });
</script>