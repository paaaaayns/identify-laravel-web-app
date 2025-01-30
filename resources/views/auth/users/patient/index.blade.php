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

        <x-forms.primary-button
            type="button"
            onclick="openModal()"
            data-modal-target="camera-modal"
            class="w-full">
            Search Iris
        </x-forms.primary-button>

        <div>
            <livewire:patient-table />
        </div>
    </div>

    <!-- Main modal -->
    <div
        id="camera-modal"
        onclick="handleModalBackgroundClick(event)"
        tabindex="-1"
        aria-hidden="true"
        class="hidden bg-gray-800 bg-opacity-75 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-center items-center p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Look at the camera
                    </h3>
                </div>
                <!-- Modal Body -->
                <div class="p-4">
                    <video id="video" class="w-full bg-gray-300 rounded-md" autoplay></video>
                    <canvas id="canvas" class="hidden"></canvas>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-center items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button
                        onclick="captureImage()"
                        data-modal-hide="camera-modal"
                        type="button"
                        class="text-white bg-primary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Capture
                    </button>
                </div>
            </div>
        </div>
    </div>

</x-layout>



<script defer>
    let videoStream;

    function openModal() {
        const modal = document.getElementById('camera-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        openCamera();
    }

    function closeModal() {
        const modal = document.getElementById('camera-modal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');

        closeCamera();
    }

    async function openCamera() {
        // Start the camera
        const video = document.getElementById('video');
        videoStream = await navigator.mediaDevices.getUserMedia({
            video: true
        });
        video.srcObject = videoStream;
        video.play();
    }

    function closeCamera() {
        // Stop the camera
        if (videoStream) {
            const tracks = videoStream.getTracks();
            tracks.forEach(track => track.stop());
        }
    }

    function handleModalBackgroundClick(event) {
        const modal = document.getElementById('camera-modal');
        if (event.target === modal) {
            closeModal();
        }
    }

    function captureImage() {
        const canvas = document.getElementById('canvas');
        const video = document.getElementById('video');
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convert the canvas image to Base64
        const imageData = canvas.toDataURL('image/png');

        // Send the image to the server
        fetch('/biometrics/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    image: imageData,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('toast-success', data.message);

                    // refresh the page after 2 seconds
                    setTimeout(() => {
                        // refresh the page
                        window.location.reload();
                    }, 2000);

                    closeCamera();
                } else {
                    showToast('toast-error', data.message);
                    alert('Error storing image.');
                    closeCamera();
                }
            })
            .catch(error => {
                showToast('toast-error', 'An error occurred while storing the image.');
                console.error('Error:', error);
                closeCamera();
            });
    }
</script>