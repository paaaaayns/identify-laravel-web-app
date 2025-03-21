<!-- Consultation -->
<div class="w-full flex flex-col items-center bg-white rounded-lg shadow">

    @if (!empty($queue))

    <div class="w-full p-6">
        <h3 class="text-xl font-semibold text-gray-800 pb-4">Attached Files</h3>
        @php
        $attachmentsPath = "patients/{$queue->patient->ulid}/medical-records/{$queue->ulid}/attachments";
        $files = Storage::disk('public')->files($attachmentsPath);
        @endphp

        <script>
            console.log("{{ $attachmentsPath }}");
        </script>
        <div class="grid grid-cols-1 border-t border-gray-400 ">
            @if (count($files) > 0)
            @foreach ($files as $file)
            <div class="!border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold">{{ basename($file) }}</span>
                    <div class="space-x-2">
                        <a href="{{ Storage::url($file) }}" download class="text-primary text-sm">Download</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="!border-t-0 border border-gray-400 px-4 py-2 md:col-span-12">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold">No files uploaded.</span>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif


    @role(['admin', 'doctor'])
    @include('auth.queue.form-files')
    @endrole
</div>