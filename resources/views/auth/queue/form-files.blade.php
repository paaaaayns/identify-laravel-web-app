<form id="FileUploadForm"
    method="POST"
    action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}"
    class="w-full">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1">
        <div class="p-6 !pt-0">
            <h3 class="text-xl font-semibold text-gray-800">Upload Files</h3>
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

        @role(['admin', 'opd', 'doctor'])
        <div class="p-6 !pt-0">
            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
                <x-forms.primary-button
                    type="button"
                    onclick="updateQueue('FileUploadForm')">
                    Save
                </x-forms.primary-button>
            </div>
        </div>
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