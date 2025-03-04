<!-- Doctor Selection -->

<div class="grid grid-cols-1 md:grid-cols-5 gap-6">
    <!-- Left Column -->
    <div class="hidden md:block space-y-4 md:col-span-2">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="pb-4 col-span-6 md:col-span-12">
                <h3 class="text-xl font-semibold text-gray-800">
                    Patient Medical History
                </h3>
            </div>
            <livewire:patient-history-table :queue_id="$queue->ulid" :patient_id="$queue->patient_id" />
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-4 col-span-1 md:col-span-3 break-words">

        <div class="bg-white shadow rounded-lg p-6">

            <!-- Personal Information -->
            <div class="w-full grid grid-cols-6 md:grid-cols-12">
                <!-- center vertically the children-->
                <div class="flex justify-between items-center pb-4 col-span-6 md:col-span-12">
                    <span id="mr-created_at" class="text-xl font-semibold text-gray-800"></span>
                    <button
                        id="download-btn"
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
                        <span id="p-user_id" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">First Name</label>
                        <span id="p-first_name" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Middle Name</label>
                        <span id="p-middle_name" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Last Name</label>
                        <span id="p-last_name" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Sex</label>
                        <span id="p-sex" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Birthdate</label>
                        <span id="p-birthdate" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Religion</label>
                        <span id="p-religion" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                    <div class="flex flex-col">
                        <label class="text-sm">Citizenship</label>
                        <span id="p-citizenship" class="text-sm font-semibold"></span>
                    </div>
                </div>

                <!-- Consultation Information -->
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Consultation Information</h3>
                </div>
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Doctor</h3>
                </div>

                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-6">
                    <div class="flex flex-col">
                        <label class="text-sm">Name</label>
                        <span id="d-name" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-6">
                    <div class="flex flex-col">
                        <label class="text-sm">Specialization</label>
                        <span id="d-specialization" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-6">
                    <div class="flex flex-col">
                        <label class="text-sm">Contact No.</label>
                        <span id="d-contact_number" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-6">
                    <div class="flex flex-col">
                        <label class="text-sm">Email</label>
                        <span id="d-email" class="text-sm font-semibold"></span>
                    </div>
                </div>


                <!-- Concerns -->
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Concerns</h3>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Primary Complaint</label>
                        <span id="mr-primary_complaint" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Duration of Symptoms</label>
                        <span id="mr-duration_of_symptoms" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Intensity & Frequency</label>
                        <span id="mr-intensity_and_frequency" class="text-sm font-semibold"></span>
                    </div>
                </div>

                <!-- Concerns -->
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Concerns</h3>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Primary Complaint</label>
                        <span id="mr-primary_complaint" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Duration of Symptoms</label>
                        <span id="mr-duration_of_symptoms" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                    <div class="flex flex-col">
                        <label class="text-sm">Intensity & Frequency</label>
                        <span id="mr-intensity_and_frequency" class="text-sm font-semibold"></span>
                    </div>
                </div>


                <!-- Findings -->
                <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                    <h3 class="text-sm font-semibold text-gray-800">Findings</h3>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Findings</label>
                        <span id="mr-findings" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Diagnosis</label>
                        <span id="mr-diagnosis" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Recommended Treatment</label>
                        <span id="mr-recommended_treatment" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Follow-Up Instructions</label>
                        <span id="mr-follow_up_instructions" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Referrals</label>
                        <span id="mr-referrals" class="text-sm font-semibold"></span>
                    </div>
                </div>
                <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                    <div class="flex flex-col">
                        <label class="text-sm">Doctor's Notes</label>
                        <span id="mr-doctor_notes" class="text-sm font-semibold"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>