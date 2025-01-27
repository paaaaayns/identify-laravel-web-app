<table class="w-full table-fixed border-collapse border border-gray-400">
    <!--  Personal Information -->
    <tr class="bg-gray-200">
        <td class="border border-gray-400 px-4 py-2" colspan="12">
            <span class="text-sm font-semibold text-gray-800">Personal Information</span>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">First Name</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->first_name ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Middle Name</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->middle_name ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Last Name</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->last_name ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Patient ID</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->user_id ?? 'N/A' }}</span>
            </div>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Sex</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->sex ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Birthdate</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->birthdate ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Religion</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->religion ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Citizenship</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->citizenship ?? 'N/A' }}</span>
            </div>
        </td>
    </tr>

    <!-- Emergency Contact Section -->
    <tr class="bg-gray-200">
        <td class="border border-gray-400 px-4 py-2" colspan="12">
            <span class="text-sm font-semibold text-gray-800">Emergency Contact</span>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Name</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->emergency_contact1_name ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Contact No.</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->emergency_contact1_number ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Relationship</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->emergency_contact1_relationship ?? 'N/A' }}</span>
            </div>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Name</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->emergency_contact2_name ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Contact No.</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->emergency_contact2_number ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Relationship</label>
                <span class="border-b border-black text-sm font-semibold">{{ $patient->emergency_contact2_relationship ?? 'N/A' }}</span>
            </div>
        </td>
    </tr>

    <!-- Medical Record Section -->
    <tr class="bg-gray-200">
        <td class="border border-gray-400 px-4 py-2" colspan="12">
            <span class="text-sm font-semibold text-gray-800">Consultation Information</span>
        </td>
    </tr>
    <tr class="bg-gray-200">
        <td class="border border-gray-400 px-4 py-2" colspan="12">
            <span class="text-sm font-semibold text-gray-800">Doctor Information</span>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Name</label>
                <span class="border-b border-black text-sm font-semibold">Dr. {{ $doctor->first_name . ' ' . $doctor->last_name ?? 'N/A' }} </span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Specialization</label>
                <span class="border-b border-black text-sm font-semibold">{{ $doctor->type ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Contact No.</label>
                <span class="border-b border-black text-sm font-semibold">{{ $doctor->contact_number ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Email</label>
                <span class="border-b border-black text-sm font-semibold">{{ $doctor->email ?? 'N/A' }}</span>
            </div>
        </td>
    </tr>
    <tr class="bg-gray-200">
        <td class="border border-gray-400 px-4 py-2" colspan="12">
            <span class="text-sm font-semibold text-gray-800">Assessment</span>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Height</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->height ?? 'N/A' }} cm</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Weight</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->weight ?? 'N/A' }} kg</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Blood Pressure</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->blood_pressure ?? 'N/A' }} mmHg</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="3">
            <div class="flex flex-col">
                <label class="text-sm">Temperature</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->temperature ?? 'N/A' }} °C</span>
            </div>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Pulse Rate</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->pulse_rate ?? 'N/A' }} bpm</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Respiration Rate</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->respiration_rate ?? 'N/A' }} bpm</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">O2 Saturation</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->o2_sat ?? 'N/A' }} %</span>
            </div>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="12">
            <div class="flex flex-col">
                <label class="text-sm">Other</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->other ?? 'N/A' }}</span>
            </div>
        </td>
    </tr>


    <tr class="bg-gray-200">
        <td class="border border-gray-400 px-4 py-2" colspan="12">
            <span class="text-sm font-semibold text-gray-800">Consultation</span>
        </td>
    </tr>
    <tr>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Primary Complaint</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->primary_complaint ?? 'N/A' }} bpm</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2 align-top" colspan="4">
            <div class="flex flex-col h-full">
                <label class="text-sm">Duration of Symptoms</label>
                <span class="flex-grow border-b border-black text-sm font-semibold h-full">{{ $record->duration_of_symptoms ?? 'N/A' }}</span>
            </div>
        </td>
        <td class="border border-gray-400 px-4 py-2" colspan="4">
            <div class="flex flex-col">
                <label class="text-sm">Intensity and Frequency</label>
                <span class="border-b border-black text-sm font-semibold">{{ $record->intensity_and_frequency ?? 'N/A' }} %</span>
            </div>
        </td>
    </tr>
</table>