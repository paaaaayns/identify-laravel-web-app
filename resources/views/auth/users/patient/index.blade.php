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
                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Users</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="size-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('users.patient.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Registered Patients</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex flex-col space-y-4">


        @role(['admin', 'opd'])
        <form
            id="SearchForm"
            method="POST"
            action="{{ route('iris-biometrics.search') }}"
            class="flex flex-col space-y-4 bg-white rounded-lg shadow p-6">
            <x-forms.field-container class="sm:col-span-6 grid place-items-center">
                <x-forms.label for="iris">
                    Iris
                </x-forms.label>
                <!-- Hidden File Input -->
                <input
                    type="file"
                    id="iris"
                    name="iris"
                    accept="image/*"
                    class="hidden"
                    onchange="previewImage(event, 'iris', 'iris_preview', 'iris_text')">
                <x-forms.error name="iris" />
                <!-- Upload Box -->
                <label
                    for="iris"
                    class="cursor-pointer w-40 h-40 flex items-center text-center justify-center border-2 border-dashed border-gray-300 rounded-lg shadow text-gray-500 hover:border-primary hover:text-primary overflow-hidden">
                    <span id="iris_text">Click to upload an image</span>
                    <img id="iris_preview" alt="Right Iris" class="hidden w-full h-full object-cover">
                </label>

            </x-forms.field-container>
            <x-forms.primary-button
                type="button"
                onclick="searchPatient()"
                class="w-full">
                Search Iris
            </x-forms.primary-button>
        </form>
        @endrole

        <div>
            <livewire:patient-table />
        </div>
    </div>

</x-layout>


<!-- Iris Preview Script -->
<script>
    function previewImage(event, input_id, image_id, text_id) {
        const file = event.target.files[0];
        const preview = document.getElementById(image_id);
        const uploadText = document.getElementById(text_id);

        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                uploadText.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<script>
    async function searchPatient(params) {
        const form = document.getElementById('SearchForm');
        const formData = new FormData(form);


        // Convert images to Base64
        // const IrisFile = document.getElementById('iris').files[0];
        // if (IrisFile) {
        //     formData.delete('iris'); // Remove original file input
        //     formData.append('iris', await toBase64(IrisFile));
        // }

        console.log("formData", formData);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });

            const result = await response.json();

            if (response.ok) {
                showToast('toast-success', result.message);
                console.log(response.status, result.message);
                console.log('Data:', result.data.patient.ulid);

                // redirect to the patient profile page
                window.location.href = `/users/patient/${result.data.patient.ulid}`;
            } else {
                showToast('toast-error', result.message);
                console.error(response.status, result.message);
                return null;
            }
        } catch (error) {
            showToast('toast-error', 'Failed to find a record.');
            console.error('Failed to find a record.', error);
            return null;
        }


    }

    function toBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = (error) => reject(error);
        });
    }
</script>