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
                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">{{ $patient->user_id }}</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Left Column -->
        <div class="space-y-4 md:col-span-1">
            <div class="flex flex-col items-center text-center bg-white shadow rounded-lg p-6 self-start">
                <!-- Profile Picture -->
                <div class="w-32 h-32 mb-4">
                    <img src="https://via.placeholder.com/150" alt="Profile Picture" class="w-full h-full rounded-full shadow">
                </div>
                <!-- User Info -->
                <h2 class="text-lg font-semibold text-gray-800">{{ $patient->first_name }} {{ $patient->middle_name ?? '' }} {{ $patient->last_name }}</h2>
                <p class="text-sm text-gray-500">{{ $patient->user_id }}</p>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-4 md:col-span-3">

            <!-- Tabs -->
            <div class="flex flex-row justify-between">
                <div class="grid grid-cols-1 sm:hidden">
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select aria-label="Select a tab" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                        <option>My Account</option>
                        <option>Company</option>
                        <option selected>Team Members</option>
                        <option>Billing</option>
                    </select>
                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </div>

                <div class="hidden sm:block">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <!-- Current: "bg-indigo-100 text-indigo-700", Default: "text-gray-500 hover:text-gray-700" -->
                        <a href="?tab=profile" data-target="profile" class="tab-link rounded-md bg-primary px-3 py-2 text-sm font-medium text-white" aria-current="page">Profile</a>
                        <a href="?tab=doctor" data-target="doctor" class="tab-link rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Doctor</a>
                        <a href="?tab=vitals" data-target="vitals" class="tab-link rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Vitals</a>
                    </nav>
                </div>

                <div class="hidden sm:flex flex-row gap-6">
                    <div class="flex flex-row">
                        <span class="rounded-md px-3 py-2 text-sm font-medium text-gray-500">Status</span>
                        <x-forms.select
                            id="queue_status"
                            name="queue_status"
                            aria-label="Select a status"
                            class="!m-0">
                            <option selected>Waiting</option>
                            <option>Vitals Taken</option>
                            <option>Consulting</option>
                            <option>Completed</option>
                            <option>Cancelled</option>
                        </x-forms.select>
                    </div>

                    <x-forms.primary-button
                        type="button"
                        onclick="confirmCreate()">
                        Save
                    </x-forms.primary-button>
                </div>
            </div>

            <!-- Profile Tab -->
            <div id="profile" class="tab-content space-y-4">
                @include('auth.queue.tab-profile')
            </div>

            <div id="doctor" class="tab-content hidden">
                @include('auth.queue.tab-doctor')
            </div>

            <div id="vitals" class="tab-content hidden">
                @include('auth.queue.tab-vitals')
            </div>
        </div>
    </div>

    <!-- <script>
        const tabLinks = document.querySelectorAll(".tab-link");
        const tabContents = document.querySelectorAll(".tab-content");

        tabLinks.forEach((tab) => {
            tab.addEventListener("click", (e) => {
                e.preventDefault();

                // Remove active state from all tabs
                tabLinks.forEach((link) => link.classList.remove("bg-primary", "text-white"));
                // Add default state to all tabs
                tabLinks.forEach((link) => link.classList.add("text-gray-500", "hover:text-gray-700"));
                tabContents.forEach((content) => content.classList.add("hidden"));

                // Add active state to clicked tab and show corresponding content
                tab.classList.add("bg-primary", "text-white");
                tab.classList.remove("text-gray-500", "hover:text-gray-700");
                const target = tab.getAttribute("data-target");
                document.getElementById(target).classList.remove("hidden");
            });
        });
    </script> -->


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
                history.pushState(null, "", `?tab=${targetId}`);
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
</x-layout>