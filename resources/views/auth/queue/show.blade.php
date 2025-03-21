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
                        <a href="{{ route('queue.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Queue</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="size-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">{{ $queue->queue_id }}</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <div class="space-y-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 bg-white shadow rounded-lg p-6">
                <div class="border border-gray-400 divide-y divide-gray-400">
                    <div class="bg-gray-200 px-4 py-2">
                        <h3 class="text-sm font-semibold text-gray-800">Patient</h3>
                    </div>
                    <div class=" px-4 py-2">
                        <div class="flex flex-col">
                            <label class="text-sm">Name</label>
                            <span id="p-user_id" class="text-sm font-semibold">{{ $queue?->patient ? trim("{$queue->patient->first_name} {$queue->patient->middle_name} {$queue->patient->last_name}") : '' }}</span>
                        </div>
                    </div>
                </div>

                <div class="!border-l-0 border border-gray-400 divide-y divide-gray-400">
                    <div class="bg-gray-200 px-4 py-2">
                        <h3 class="text-sm font-semibold text-gray-800">Doctor</h3>
                    </div>
                    <div class="px-4 py-2">
                        <div class="flex flex-col">
                            <label class="text-sm">Name</label>
                            <span id="p-user_id" class="text-sm font-semibold">{{ $queue?->doctor ? trim("Dr. {$queue->doctor->first_name} {$queue->doctor->middle_name} {$queue->doctor->last_name}") : 'Not yet selected' }}</span>
                        </div>
                    </div>
                </div>

                <div class="!border-l-0 border border-gray-400 divide-y divide-gray-400">
                    <div class="bg-gray-200 px-4 py-2">
                        <h3 class="text-sm font-semibold text-gray-800">OPD</h3>
                    </div>
                    <div class="px-4 py-2">
                        <div class="flex flex-col">
                            <label class="text-sm">Name</label>
                            <span id="p-user_id" class="text-sm font-semibold">{{ $queue?->opd ? trim("{$queue->opd->first_name} {$queue->opd->middle_name} {$queue->opd->last_name}") : 'Not yet selected' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tabs -->
        <div class="flex flex-row justify-between">
            <!-- Mobile Tab Select -->
            <div class="grid grid-cols-1 sm:hidden relative">
                <select id="mobile-tab-select" aria-label="Select a tab"
                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-primary">
                    <option value="profile">Profile</option>
                    <option value="history">History</option>
                    @if ($queue->doctor_selected_at === null)
                    <option value="doctor">Doctor</option>
                    @endif
                    <option value="files">Files</option>
                    <option value="assessment">Assessment</option>
                    <option value="consultation">Consultation</option>
                </select>
            </div>

            <div class="hidden sm:block">
                <nav class="flex space-x-4" aria-label="Tabs">
                    <!-- Current: "bg-indigo-100 text-indigo-700", Default: "text-gray-500 hover:text-gray-700" -->
                    <a href="?tab=profile" data-target="profile" class="tab-link rounded-md bg-primary px-3 py-2 text-sm font-medium text-white" aria-current="page">Profile</a>
                    <a href="?tab=history" data-target="history" class="tab-link rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">History</a>
                    @if ($queue->doctor_selected_at === null)
                    <a href="?tab=doctor" data-target="doctor" class="tab-link rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Doctor</a>
                    @endif
                    <a href="?tab=files" data-target="files" class="tab-link rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Files</a>
                    <a href="?tab=assessment" data-target="assessment" class="tab-link rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Assessment</a>
                    <a href="?tab=consultation" data-target="consultation" class="tab-link rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Consultation</a>
                </nav>
            </div>


            <div class="flex flex-row">
                <span class="rounded-md px-3 py-2 text-sm font-medium text-gray-500">Status</span>
                @php
                $statusClass = match ($queue->queue_status) {
                'Awaiting Doctor Selection' => 'bg-yellow-500 text-white',
                'Awaiting Assessment' => 'bg-amber-400 text-white',
                'Assessing' => 'bg-blue-500 text-white',
                'Awaiting Consultation' => 'bg-cyan-500 text-white',
                'Consulting' => 'bg-orange-500 text-white',
                'Completed' => 'bg-green-500 text-white',
                'Cancelled' => 'bg-red-500 text-white',
                default => 'text-gray-500',
                };
                @endphp
                <span class="rounded-md px-3 py-2 text-sm font-medium {{ $statusClass }}">
                    {{ $queue->queue_status }}
                </span>
            </div>
        </div>

        <!-- Profile Tab -->
        <div id="profile" class="tab-content space-y-4">
            @include('auth.queue.tab-profile')
        </div>

        <!-- Patient Medical History Tab -->
        <div id="history" class="tab-content hidden">
            @include('auth.queue.tab-history')
        </div>

        <!-- Doctor Selection Tab -->
        <div id="doctor" class="tab-content hidden">
            @include('auth.queue.tab-doctor')
        </div>
        
        <!-- File Upload Tab -->
        <div id="files" class="tab-content hidden">
            @include('auth.queue.tab-files')
        </div>

        <!-- Assessment Tab -->
        <div id="assessment" class="tab-content hidden">
            @include('auth.queue.tab-assessment')
        </div>

        <!-- Consultation Tab -->
        <div id="consultation" class="tab-content hidden">
            @include('auth.queue.tab-consultation')
        </div>
    </div>

    <!-- Update Script -->
    <script>
        async function updateQueue(formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            const formAction = form.action;

            try {
                const response = await fetch(formAction, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                });

                const result = await response.json();

                if (response.ok) {
                    showToast('toast-success', result.message);
                    console.log(response.status, result.message, result.queue);
                    if (result.isConsultationDone) {
                        window.location.href = `{{ route('queue.index') }}`;
                    } else {
                        location.reload();
                    }
                } else {
                    showToast('toast-error', result.message);
                    console.error(response.status, result.message);
                }
            } catch (error) {
                showToast('toast-error', 'An error occurred while processing the request.');
                console.error('Fetch error:', error);
                return null;
            }
        }
    </script>

    <script>
        const tabLinks = document.querySelectorAll(".tab-link");
        const tabContents = document.querySelectorAll(".tab-content");

        function showTab(targetId) {
            // Remove active state from all tabs
            tabLinks.forEach((link) => {
                link.classList.remove("bg-primary", "text-white");
                link.classList.add("text-gray-500", "hover:text-gray-700");
            });

            // Hide all tab contents
            tabContents.forEach((content) => content.classList.add("hidden"));

            // Activate the correct tab and show its content
            const activeTab = document.querySelector(`[data-target="${targetId}"]`);
            const targetContent = document.getElementById(targetId);

            if (activeTab && targetContent) {
                activeTab.classList.add("bg-primary", "text-white");
                activeTab.classList.remove("text-gray-500", "hover:text-gray-700");
                targetContent.classList.remove("hidden");

                // Update the URL to include the active tab
                // history.pushState(null, "", `?tab=${targetId}`);
                // Preserve existing query parameters
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set("tab", targetId); // Update tab

                history.pushState(null, "", `?${urlParams.toString()}`);
            }
        }

        // Add click event listeners to all tabs
        tabLinks.forEach((tab) => {
            tab.addEventListener("click", (e) => {
                e.preventDefault();
                const target = tab.getAttribute("data-target");
                showTab(target);
            });
        });

        // Handle initial load or reload
        const urlParams = new URLSearchParams(window.location.search);
        const initialTab = urlParams.get("tab") || tabLinks[0].getAttribute("data-target"); // Default to the first tab
        showTab(initialTab);
    </script>

    <!-- JavaScript to handle tabs -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');
            const mobileSelect = document.getElementById('mobile-tab-select');

            function showTab(target) {
                // Hide all tab contents
                tabContents.forEach(tab => tab.classList.add('hidden'));
                // Remove active class from all desktop links
                tabLinks.forEach(link => link.classList.remove('bg-primary', 'text-white'));
                tabLinks.forEach(link => link.classList.add('text-gray-500'));

                // Show selected tab content
                const selectedTab = document.getElementById(target);
                if (selectedTab) {
                    selectedTab.classList.remove('hidden');
                }

                // Highlight active tab in desktop view
                tabLinks.forEach(link => {
                    if (link.dataset.target === target) {
                        link.classList.add('bg-primary', 'text-white');
                        link.classList.remove('text-gray-500');
                    }
                });

                // Set mobile select to correct value
                if (mobileSelect) {
                    mobileSelect.value = target;
                }
            }

            // Desktop tab clicks
            tabLinks.forEach(link => {
                link.addEventListener('click', () => {
                    const target = link.getAttribute('data-target');
                    showTab(target);
                });
            });

            // Mobile select change
            if (mobileSelect) {
                mobileSelect.addEventListener('change', (e) => {
                    showTab(e.target.value);
                });
            }

            // On page load, optionally set initial tab (e.g., via query string ?tab=assessment)
            const urlParams = new URLSearchParams(window.location.search);
            const initialTab = urlParams.get('tab') || 'profile';
            showTab(initialTab);
        });
    </script>

    <script>
        const mobileTabSelect = document.getElementById("mobile-tab-select");

        // Listen to mobile select change
        if (mobileTabSelect) {
            mobileTabSelect.addEventListener("change", (e) => {
                const selectedTab = e.target.value;
                showTab(selectedTab);
            });

            // Pre-select the correct value on page load
            const currentTab = new URLSearchParams(window.location.search).get("tab");
            if (currentTab) {
                mobileTabSelect.value = currentTab;
            }
        }
    </script>

</x-layout>