<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Record</title>
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="bg-white rounded-lg p-6">

        <div class="w-full grid grid-cols-6 md:grid-cols-12">
            <div class="flex justify-between items-center pb-2 col-span-6 md:col-span-12">
                <span class="text-xl font-semibold text-gray-800"> {{ $record->created_at->format('M d, Y') }} | {{ $record->medical_record_id }} </span>
            </div>

            <!-- Personal Information -->
            <div class="w-full grid grid-cols-6 md:grid-cols-12 col-span-6 md:col-span-12">
                <div class="bg-gray-200 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Personal Information</h3>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Patient ID</label>
                        <span class="text-sm font-semibold">{{ $record->patient->user_id ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-9">
                    <div class="flex flex-col">
                        <label class="text-sm">Name</label>
                        <span class="text-sm font-semibold">{{ $record->patient->first_name ?? 'N/A' }} {{ $record->patient->middle_name ?? '' }} {{ $record->patient->last_name ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Sex</label>
                        <span class="text-sm font-semibold">{{ $record->patient->sex ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Birthdate</label>
                        <span class="text-sm font-semibold">{{ $record->patient->birthdate ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Religion</label>
                        <span class="text-sm font-semibold">{{ $record->patient->religion ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Citizenship</label>
                        <span class="text-sm font-semibold">{{ $record->patient->citizenship ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Consultation Information -->
            <div class="w-full grid grid-cols-6 md:grid-cols-12 col-span-6 md:col-span-12">
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Consultation Information</h3>
                </div>

                <!-- Doctor Information -->
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Doctor</h3>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Name</label>
                        <span class="text-sm font-semibold">Dr. {{ $record->doctor->first_name . ' ' . $record->doctor->last_name ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Profession</label>
                        <span class="text-sm font-semibold">{{ $record->doctor->type ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Contact No.</label>
                        <span class="text-sm font-semibold">{{ $record->doctor->contact_number ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Email</label>
                        <span class="text-sm font-semibold">{{ $record->doctor->email ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Concerns -->
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Concerns</h3>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Primary Complaint</label>
                        <span class="text-sm font-semibold">{{ $record->primary_complaint ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Duration of Symptoms</label>
                        <span class="text-sm font-semibold">{{ $record->duration_of_symptoms ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Intensity & Frequency</label>
                        <span class="text-sm font-semibold">{{ $record->intensity_and_frequency ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Vitals -->
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Vitals</h3>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Height</label>
                        <span class="text-sm font-semibold">{{ $record->height ?? 'N/A' }} cm</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Weight</label>
                        <span class="text-sm font-semibold">{{ $record->weight ?? 'N/A' }} kg</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Blood Pressure</label>
                        <span class="text-sm font-semibold">{{ $record->blood_pressure ?? 'N/A' }} mmHg</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Temperature</label>
                        <span class="text-sm font-semibold">{{ $record->temperature ?? 'N/A' }} °C</span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Pulse Rate</label>
                        <span class="text-sm font-semibold">{{ $record->pulse_rate ?? 'N/A' }} bpm</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Respiration Rate</label>
                        <span class="text-sm font-semibold">{{ $record->respiration_rate ?? 'N/A' }} bpm</span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">O2 Saturation</label>
                        <span class="text-sm font-semibold">{{ $record->o2_sat ?? 'N/A' }} %</span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Other</label>
                        <span class="text-sm font-semibold">{{ $record->other ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Findings -->
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Findings</h3>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Findings</label>
                        <span class="text-sm font-semibold">{{ $record->findings ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Diagnosis</label>
                        <span class="text-sm font-semibold">{{ $record->diagnosis ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Recommended Treatment</label>
                        <span class="text-sm font-semibold">{{ $record->recommended_treatment ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Follow-Up Instructions</label>
                        <span class="text-sm font-semibold">{{ $record->follow_up_instructions ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Referrals</label>
                        <span class="text-sm font-semibold">{{ $record->referrals ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Doctor's Notes</label>
                        <span class="text-sm font-semibold">{{ $record->doctor_notes ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>

</html>