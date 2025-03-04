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
                        <a href="{{ route('medical-record.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Medical Records</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="size-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('medical-record.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $record->medical_record_id }}</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>



    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <!-- Left Column -->
        <div class="hidden md:block space-y-4 md:col-span-2">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="pb-4 col-span-6 md:col-span-12">
                    <h3 class="text-xl font-semibold text-gray-800">
                        @role(['admin', 'doctor', 'opd'])
                        My Past Patients
                        @else
                        My Medical Records
                        @endrole
                    </h3>
                </div>
                <livewire:medical-record-table />
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-4 col-span-1 md:col-span-3 break-words">

            <div class="bg-white shadow rounded-lg p-6">

                <!-- Personal Information -->
                <div class="w-full grid grid-cols-6 md:grid-cols-12">
                    <!-- center vertically the children-->
                    <div class="flex justify-between items-center pb-4 col-span-6 md:col-span-12">
                        <span class="text-xl font-semibold text-gray-800"> {{ $record->created_at->format('M d, Y') }} | {{ $record->medical_record_id }} </span>
                        <button onclick="downloadPdf('{{ $record->ulid }}')"
                            download="test.pdf"
                            class="text-blue-500 underline">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1F555F" class="size-6">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-gray-200 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                        <h3 class="text-sm font-semibold text-gray-800">Personal Information</h3>
                    </div>
                    <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Patient ID</label>
                            <span class="text-sm font-semibold">{{ $patient->user_id ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">First Name</label>
                            <span class="text-sm font-semibold">{{ $patient->first_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Middle Name</label>
                            <span class="text-sm font-semibold">{{ $patient->middle_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Last Name</label>
                            <span class="text-sm font-semibold">{{ $patient->last_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Sex</label>
                            <span class="text-sm font-semibold">{{ $patient->sex ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Birthdate</label>
                            <span class="text-sm font-semibold">{{ $patient->birthdate ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Religion</label>
                            <span class="text-sm font-semibold">{{ $patient->religion ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Citizenship</label>
                            <span class="text-sm font-semibold">{{ $patient->citizenship ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                        <h3 class="text-sm font-semibold text-gray-800">Emergency Contact</h3>
                    </div>
                    <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-4">
                        <div class="flex flex-col">
                            <label class="text-sm">Name</label>
                            <span class="text-sm font-semibold">{{ $patient->emergency_contact1_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                        <div class="flex flex-col">
                            <label class="text-sm">Contact No.</label>
                            <span class="text-sm font-semibold">{{ $patient->emergency_contact1_number ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                        <div class="flex flex-col">
                            <label class="text-sm">Relationship</label>
                            <span class="text-sm font-semibold">{{ $patient->emergency_contact1_relationship ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-4">
                        <div class="flex flex-col">
                            <label class="text-sm">Name</label>
                            <span class="text-sm font-semibold">{{ $patient->emergency_contact2_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                        <div class="flex flex-col">
                            <label class="text-sm">Contact No.</label>
                            <span class="text-sm font-semibold">{{ $patient->emergency_contact2_number ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                        <div class="flex flex-col">
                            <label class="text-sm">Relationship</label>
                            <span class="text-sm font-semibold">{{ $patient->emergency_contact2_relationship ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Consultation Information -->
                    <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                        <h3 class="text-sm font-semibold text-gray-800">Consultation Information</h3>
                    </div>
                    <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                        <h3 class="text-sm font-semibold text-gray-800">Doctor</h3>
                    </div>

                    <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Name</label>
                            <span class="text-sm font-semibold">Dr. {{ $doctor->first_name . ' ' . $doctor->last_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Specialization</label>
                            <span class="text-sm font-semibold">{{ $doctor->type ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Contact No.</label>
                            <span class="text-sm font-semibold">{{ $doctor->contact_number ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                        <div class="flex flex-col">
                            <label class="text-sm">Email</label>
                            <span class="text-sm font-semibold">{{ $doctor->email ?? 'N/A' }}</span>
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

    </div>
</x-layout>


<script>
    function downloadPdf(ulid) {
        // Create a direct download link
        const link = document.createElement('a');
        link.href = `/api/medical-record/${ulid}/download`;
        link.setAttribute('download', `${ulid}.pdf`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>