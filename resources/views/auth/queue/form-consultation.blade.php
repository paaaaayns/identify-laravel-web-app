<form id="ConsultationForm"
    method="POST"
    action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
    class="w-full">
    @csrf
    @method('PUT')

    <input type="hidden" name="queue_status" value="Completed">

    <div class="grid grid-cols-1">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800">Consultation & Plans</h3>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="findings">
                        Findings
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="findings"
                        name="findings"
                        rows="3"
                        :value="$queue->findings"
                        :disabled="$queue->consultation_done_at ? true : false" />
                    <x-forms.error name="findings" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="diagnosis">
                        Diagnosis
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="diagnosis"
                        name="diagnosis"
                        rows="3"
                        :value="$queue->diagnosis"
                        :disabled="$queue->consultation_done_at ? true : false" />
                    <x-forms.error name="diagnosis" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="recommended_treatment">
                        Recommended Treatment
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="recommended_treatment"
                        name="recommended_treatment"
                        rows="3"
                        :value="$queue->recommended_treatment"
                        :disabled="$queue->consultation_done_at ? true : false" />
                    <x-forms.error name="recommended_treatment" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="follow_up_instructions">
                        Follow-up Instructions
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="follow_up_instructions"
                        name="follow_up_instructions"
                        rows="3"
                        :value="$queue->follow_up_instructions"
                        :disabled="$queue->consultation_done_at ? true : false" />
                    <x-forms.error name="follow_up_instructions" />
                </x-forms.field-container>

                <x-forms.field-container class="sm:col-span-6">
                    <x-forms.label
                        for="referrals">
                        Referrals
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="referrals"
                        name="referrals"
                        rows="3"
                        :value="$queue->referrals"
                        :disabled="$queue->consultation_done_at ? true : false" />
                    <x-forms.error name="referrals" />
                </x-forms.field-container>
            </div>
        </div>

        <div class="p-6 !pt-0">
            <h3 class="text-xl font-semibold text-gray-800">Others</h3>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                <x-forms.field-container class="sm:col-span-12">
                    <x-forms.label
                        for="doctor_notes">
                        Doctor's Notes
                    </x-forms.label>
                    <x-forms.textarea
                        type="text"
                        id="doctor_notes"
                        name="doctor_notes"
                        rows="3"
                        :value="$queue->doctor_notes"
                        :disabled="$queue->consultation_done_at ? true : false" />
                    <x-forms.error name="doctor_notes" />
                </x-forms.field-container>
            </div>
        </div>

        <div class="p-6 !pt-0">
            <h3 class="text-xl font-semibold text-gray-800">Attachments</h3>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 mt-6">

                <x-forms.field-container class="sm:col-span-12">
                    <div class="mb-4">
                        <input
                            type="file"
                            id="attachments"
                            name="attachments[]"
                            multiple
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none">
                    </div>
                    <ul id="attachmentList" class="mt-2 text-sm text-gray-600 list-disc pl-5 space-y-1">
                        <!-- Uploaded file names will appear here -->
                    </ul>
                </x-forms.field-container>
            </div>
        </div>

        @role(['admin', 'doctor'])
        @if (!$queue->consultation_done_at)
        <div class="p-6 !pt-0">
            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
                <button
                    id="fill"
                    type="button"
                    onclick="fillConsultationFields()"
                    class="rounded-md px-3 py-2 text-sm font-semibold text-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                    Test
                </button>

                <x-forms.primary-button
                    type="button"
                    onclick="updateQueue('ConsultationForm')">
                    Save
                </x-forms.primary-button>
            </div>
        </div>
        @endif
        @endrole
    </div>
</form>

<script>
    const attachments = document.getElementById('attachments');
    const attachmentList = document.getElementById('attachmentList');

    attachments.addEventListener('change', () => {
        attachmentList.innerHTML = ''; // Clear previous list
        const files = attachments.files;

        if (files.length === 0) {
            const li = document.createElement('li');
            li.textContent = 'No files selected.';
            attachmentList.appendChild(li);
        } else {
            Array.from(files).forEach(file => {
                const li = document.createElement('li');
                li.textContent = file.name;
                attachmentList.appendChild(li);
            });
        }
    });
</script>