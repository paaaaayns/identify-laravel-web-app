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
                        <a href="{{ route('users.patient.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Registered Patients</a>
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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Left Column -->
        <div class="space-y-4 md:col-span-1">
            <div class="flex flex-col items-center text-center bg-white shadow rounded-lg p-6 self-start">
                <!-- Profile Picture -->
                <div class="w-40 h-40 mb-2">
                    <svg class="w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="#1F555F" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <!-- User Info -->
                <h2 class="text-lg font-semibold text-gray-800">{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name ?? '' }}</h2>
                <p class="text-sm text-gray-500">{{ $patient->user_id }}</p>
            </div>


            @role(['admin', 'opd'])
            <div class="grid grid-cols-1 text-center bg-white shadow rounded-lg gap-y-6 p-6 self-start">

                <form method="POST" action="{{ route('queue.store') }}" id="SendQueueForm" class="grid grid-cols-1 gap-y-6">
                    @csrf
                    @role(['admin'])
                    <input type="hidden" name="opd_id" value="O-00001">
                    @else
                    <input type="hidden" name="opd_id" value="{{ $user->user_id }}">
                    @endrole
                    <input type="hidden" name="patient_id" value="{{ $patient->user_id }}">
                    <x-forms.primary-button
                        type="button"
                        class="w-full"
                        onclick="confirmSend()">
                        Send to Queue
                    </x-forms.primary-button>
                </form>
            </div>
            @endrole
        </div>

        <!-- Right Column -->
        <div class="space-y-4 md:col-span-3">

            <!-- Tabs -->
            <div class="flex flex-row justify-between">
                <!-- Mobile Tab Select -->
                <div class="grid grid-cols-1 sm:hidden relative">
                    <select id="mobile-tab-select" aria-label="Select a tab"
                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-primary">
                        <option value="profile">Profile</option>
                        <option value="history">History</option>
                    </select>
                </div>

                <div class="hidden sm:block">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <!-- Current: "bg-indigo-100 text-indigo-700", Default: "text-gray-500 hover:text-gray-700" -->
                        <a href="?tab=profile" data-target="profile" class="tab-link rounded-md bg-primary px-3 py-2 text-sm font-medium text-white" aria-current="page">Profile</a>
                        <a href="?tab=history" data-target="history" class="tab-link rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">History</a>
                    </nav>
                </div>
            </div>

            <!-- Profile Tab -->
            <div id="profile" class="tab-content space-y-4">
                @include('auth.users.patient.tab-profile')
            </div>

            <!-- Patient Medical History Tab -->
            <div id="history" class="tab-content hidden">
                @include('auth.users.patient.tab-history')
            </div>
        </div>
    </div>


    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('left_iris').src = "{{ Storage::url('patients/' . $patient->ulid . '/biometrics/left_iris.bmp') }}";
            document.getElementById('right_iris').src = "{{ Storage::url('patients/' . $patient->ulid . '/biometrics/right_iris.bmp') }}";
        });
    </script>

    <!-- Confirmation dialog -->
    <script>
        async function confirmSend() {
            event.preventDefault();

            const queue = await createQueue();
            if (queue) {
                window.location.href = `/queue/${queue.ulid}`;
            }
            return;
        }

        async function createQueue() {
            const form = document.getElementById('SendQueueForm');
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });

                if (response.ok) {
                    const result = await response.json();
                    showToast('toast-success', result.message);
                    console.log(response.status, result.message);
                    console.log('Queue:', result.queue);

                    return result.queue;
                } else {
                    showToast('toast-error', 'Failed to create queue.');
                    console.error(response.status, 'Failed to create queue.');
                    return null;
                }
            } catch (error) {
                showToast('toast-error', 'An error occurred while processing the request.');
                console.error(response.status, error);
                return null;
            }
        }
    </script>



    <script>
        const tabLinks = document.querySelectorAll(".tab-link");
        const tabContents = document.querySelectorAll(".tab-content");

        function showTab(targetId) {
            tabLinks.forEach((link) => {
                link.classList.remove("bg-primary", "text-white");
                link.classList.add("text-gray-500", "hover:text-gray-700");
            });

            tabContents.forEach((content) => content.classList.add("hidden"));

            const activeTab = document.querySelector(`[data-target="${targetId}"]`);
            const targetContent = document.getElementById(targetId);

            if (activeTab && targetContent) {
                activeTab.classList.add("bg-primary", "text-white");
                activeTab.classList.remove("text-gray-500", "hover:text-gray-700");
                targetContent.classList.remove("hidden");

                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set("tab", targetId);

                history.pushState(null, "", `?${urlParams.toString()}`);
            }
        }

        tabLinks.forEach((tab) => {
            tab.addEventListener("click", (e) => {
                e.preventDefault();
                const target = tab.getAttribute("data-target");
                showTab(target);
            });
        });

        const urlParams = new URLSearchParams(window.location.search);
        const initialTab = urlParams.get("tab") || tabLinks[0].getAttribute("data-target");
        showTab(initialTab);
    </script>

    <!-- JavaScript to handle tabs -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');
            const mobileSelect = document.getElementById('mobile-tab-select');

            function showTab(target) {
                tabContents.forEach(tab => tab.classList.add('hidden'));

                tabLinks.forEach(link => link.classList.remove('bg-primary', 'text-white'));
                tabLinks.forEach(link => link.classList.add('text-gray-500'));

                const selectedTab = document.getElementById(target);
                if (selectedTab) {
                    selectedTab.classList.remove('hidden');
                }

                tabLinks.forEach(link => {
                    if (link.dataset.target === target) {
                        link.classList.add('bg-primary', 'text-white');
                        link.classList.remove('text-gray-500');
                    }
                });

                if (mobileSelect) {
                    mobileSelect.value = target;
                }
            }

            tabLinks.forEach(link => {
                link.addEventListener('click', () => {
                    const target = link.getAttribute('data-target');
                    showTab(target);
                });
            });

            if (mobileSelect) {
                mobileSelect.addEventListener('change', (e) => {
                    showTab(e.target.value);
                });
            }

            const urlParams = new URLSearchParams(window.location.search);
            const initialTab = urlParams.get('tab') || 'profile';
            showTab(initialTab);
        });
    </script>

    <script>
        const mobileTabSelect = document.getElementById("mobile-tab-select");

        if (mobileTabSelect) {
            mobileTabSelect.addEventListener("change", (e) => {
                const selectedTab = e.target.value;
                showTab(selectedTab);
            });

            const currentTab = new URLSearchParams(window.location.search).get("tab");
            if (currentTab) {
                mobileTabSelect.value = currentTab;
            }
        }
    </script>
</x-layout>