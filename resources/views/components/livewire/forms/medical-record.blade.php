<div class="w-full grid grid-cols-1">
    @php
    $record_ulid = $record ? $record->ulid : '';
    @endphp

    @if (!empty($record))
    <div class="flex justify-between items-center pb-4 col-span-6 md:col-span-12">
        <span id="mr-created_at" class="text-xl font-semibold text-gray-800">{{ $record ? $record->created_at->format('M d, Y') . ' | ' . $record->medical_record_id : '' }}</span>
        <button
            onclick="downloadPdf('{{ $record_ulid }}')"
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
    @endif


    <div class="">
        <!-- Personal Information -->
        <div class="w-full grid grid-cols-6 md:grid-cols-12 col-span-6 md:col-span-12">
            <div class="bg-gray-200 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                <h3 class="text-sm font-semibold text-gray-800">Personal Information</h3>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                <div class="flex flex-col">
                    <label class="text-sm">Patient ID</label>
                    <span id="p-user_id" class="text-sm font-semibold">{{ $record?->patient ? $record->patient->user_id : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-9">
                <div class="flex flex-col">
                    <label class="text-sm">Name</label>
                    <span id="p-first_name" class="text-sm font-semibold">{{ $record?->patient ? trim("{$record->patient->first_name} {$record->patient->middle_name} {$record->patient->last_name}") : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-3">
                <div class="flex flex-col">
                    <label class="text-sm">Sex</label>
                    <span id="p-sex" class="text-sm font-semibold">{{ $record?->patient ? $record->patient->sex : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                <div class="flex flex-col">
                    <label class="text-sm">Birthdate</label>
                    <span id="p-birthdate" class="text-sm font-semibold">{{ $record?->patient ? $record->patient->birthdate : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                <div class="flex flex-col">
                    <label class="text-sm">Religion</label>
                    <span id="p-religion" class="text-sm font-semibold">{{ $record?->patient ? $record->patient->religion : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-3">
                <div class="flex flex-col">
                    <label class="text-sm">Citizenship</label>
                    <span id="p-citizenship" class="text-sm font-semibold">{{ $record?->patient ? $record->patient->citizenship : '' }}</span>
                </div>
            </div>
        </div>

        <!-- Consultation Information -->
        <div class="w-full grid grid-cols-6 md:grid-cols-12 col-span-6 md:col-span-12">
            <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                <h3 class="text-sm font-semibold text-gray-800">Consultation Information</h3>
            </div>
            <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                <h3 class="text-sm font-semibold text-gray-800">Doctor</h3>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-6">
                <div class="flex flex-col">
                    <label class="text-sm">Name</label>
                    <span id="d-name" class="text-sm font-semibold">{{ $record?->doctor ? 'Dr. ' . $record->doctor->first_name . ' ' . $record->doctor->last_name : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-6">
                <div class="flex flex-col">
                    <label class="text-sm">Specialization</label>
                    <span id="d-specialization" class="text-sm font-semibold">{{ $record?->doctor ? $record->doctor->type : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-6">
                <div class="flex flex-col">
                    <label class="text-sm">Contact No.</label>
                    <span id="d-contact_number" class="text-sm font-semibold">{{ $record?->doctor ? $record->doctor->contact_number : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-6">
                <div class="flex flex-col">
                    <label class="text-sm">Email</label>
                    <span id="d-email" class="text-sm font-semibold">{{ $record?->doctor ? $record->doctor->email : '' }}</span>
                </div>
            </div>

            <!-- Concerns -->
            <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                <h3 class="text-sm font-semibold text-gray-800">Concerns</h3>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-4">
                <div class="flex flex-col">
                    <label class="text-sm">Primary Complaint</label>
                    <span id="mr-primary_complaint" class="text-sm font-semibold">{{ $record ? ($record->primary_complaint ?? 'N/A') : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                <div class="flex flex-col">
                    <label class="text-sm">Duration of Symptoms</label>
                    <span id="mr-duration_of_symptoms" class="text-sm font-semibold">{{ $record ? ($record->duration_of_symptoms ?? 'N/A') : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border-l-0 border border-gray-400 px-4 py-2 md:col-span-4">
                <div class="flex flex-col">
                    <label class="text-sm">Intensity & Frequency</label>
                    <span id="mr-intensity_and_frequency" class="text-sm font-semibold">{{ $record ? ($record->intensity_and_frequency ?? 'N/A') : '' }}</span>
                </div>
            </div>

            <!-- Findings -->
            <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                <h3 class="text-sm font-semibold text-gray-800">Findings</h3>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex flex-col">
                    <label class="text-sm">Findings</label>
                    <span id="mr-findings" class="text-sm font-semibold">{{ $record ? ($record->findings ?? 'N/A') : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex flex-col">
                    <label class="text-sm">Diagnosis</label>
                    <span id="mr-diagnosis" class="text-sm font-semibold">{{ $record ? ($record->diagnosis ?? 'N/A') : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex flex-col">
                    <label class="text-sm">Recommended Treatment</label>
                    <span id="mr-recommended_treatment" class="text-sm font-semibold">{{ $record ? ($record->recommended_treatment ?? 'N/A') : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex flex-col">
                    <label class="text-sm">Follow-Up Instructions</label>
                    <span id="mr-follow_up_instructions" class="text-sm font-semibold">{{ $record ? ($record->follow_up_instructions ?? 'N/A') : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex flex-col">
                    <label class="text-sm">Referrals</label>
                    <span id="mr-referrals" class="text-sm font-semibold">{{ $record ? ($record->referrals ?? 'N/A') : '' }}</span>
                </div>
            </div>
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex flex-col">
                    <label class="text-sm">Doctor's Notes</label>
                    <span id="mr-doctor_notes" class="text-sm font-semibold">{{ $record ? ($record->doctor_notes ?? 'N/A') : '' }}</span>
                </div>
            </div>
        </div>
        
        <!-- Attachments -->
        <div class="w-full grid grid-cols-6 md:grid-cols-12 col-span-6 md:col-span-12">
            <div class="bg-gray-200 border-t-0 border border-gray-400 px-4 py-2 col-span-6 md:col-span-12">
                <h3 class="text-sm font-semibold text-gray-800">Attachments</h3>
            </div>
            <!-- check if $record exists -->
            @if (!empty($record))
            @php
            $attachmentsPath = "patients/{$record->patient->ulid}/medical-records/{$record->ulid}/attachments";
            $files = Storage::disk('public')->files($attachmentsPath);
            @endphp
            @if (count($files) > 0)
            @foreach ($files as $file)
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold">{{ basename($file) }}</span>
                    <div class="space-x-2">
                        <a href="{{ Storage::url($file) }}" download class="text-primary text-sm">Download</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold">No attachments uploaded.</span>
                </div>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>

<script>
    async function downloadPdf(ulid) {
        if (!ulid) {
            showToast('toast-error', 'An error occurred while processing the request.');
            console.error('ULID is required.');
            return;
        }

        try {
            const response = await fetch(`/api/medical-record/${ulid}/download`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            // If response is JSON (e.g., error)
            const contentType = response.headers.get('content-type');

            if (contentType && contentType.includes('application/json')) {
                const json = await response.json();
                showToast('toast-error', json.message || 'Failed to download PDF.');
                console.error(json);
                return;
            }

            // If the file exists and response is a PDF, create blob and trigger download
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);

            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `${ulid}.pdf`);
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.URL.revokeObjectURL(url);
        } catch (error) {
            showToast('toast-error', 'An unexpected error occurred.');
            console.error('Download error:', error);
        }
    }
</script>