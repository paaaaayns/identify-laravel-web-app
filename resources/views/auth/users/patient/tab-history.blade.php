<!-- History -->

<div class="grid grid-cols-1 md:grid-cols-5 gap-6">
    <!-- Left Column -->
    <div class="hidden md:block space-y-4 md:col-span-2">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="pb-4 col-span-6 md:col-span-12">
                <h3 class="text-xl font-semibold text-gray-800">
                    Patient Medical History
                </h3>
            </div>
            <livewire:patient-history-table :patient_id="$patient->user_id" />
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-4 col-span-1 md:col-span-3 break-words">
        <div class="bg-white shadow rounded-lg p-6">
            <livewire:medical-record-layout />
        </div>
    </div>
</div>