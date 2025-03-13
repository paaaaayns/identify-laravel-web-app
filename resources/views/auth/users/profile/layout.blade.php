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
                        <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Profile</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div
        x-data="profileTabHandler()"
        class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                <h2 class="text-lg font-semibold text-gray-800">{{ $profile->last_name }}, {{ $profile->first_name }} {{ $profile->middle_name ?? '' }}</h2>
                <p class="text-sm text-gray-500">{{ $profile->user_id }}</p>
            </div>

            <div class="grid grid-cols-1 text-center bg-white shadow rounded-lg gap-y-6 p-6 self-start">
                <button
                    type="button"
                    @click="setTab('profile')"
                    :class="activeTab === 'profile' 
                    ? 'bg-primary text-white hover:bg-primary-dark' 
                    : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-100'"
                    class="w-full py-2 px-4 rounded-lg transition-all duration-200 font-semibold">
                    Profile
                </button>
                <button
                    type="button"
                    @click="setTab('change-password')"
                    :class="activeTab === 'change-password' 
                    ? 'bg-primary text-white hover:bg-primary-dark' 
                    : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-100'"
                    class="w-full py-2 px-4 rounded-lg transition-all duration-200 font-semibold">
                    Change Password
                </button>
            </div>
        </div>

        <!-- Right Column -->
        <!-- Profile Tab -->
        <template x-if="activeTab === 'profile'">
            <div
                id="profile"
                class="tab-content md:col-span-3">
                @role('admin')
                @include('auth.users.profile.admin')

                @elserole('opd')
                @include('auth.users.profile.opd')

                @elserole('doctor')
                @include('auth.users.profile.doctor')

                @elserole('patient')
                @include('auth.users.profile.patient')
                @endrole
            </div>
        </template>


        <!-- Change Password -->
        <template x-if="activeTab === 'change-password'">
            <div
                id="change-password"
                class="tab-content md:col-span-3 space-y-4">
                @include('auth.users.profile.change-password')
            </div>
        </template>
    </div>

    <script>
        async function updateProfile(event) {
            const form = document.getElementById('UpdateProfileForm');
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

                const result = await response.json();

                if (response.ok) {
                    showToast('toast-success', result.message);
                    reloadPage(1000);
                } else if (response.status === 422) {
                    showToast('toast-error', result.message);
                    console.log("An error occurred:", result.message);
                    showErrorMessages(result.errors);
                } else {
                    showToast('toast-error', 'An error occurred. Please try again.');
                    console.log("An error occurred:", result.message);
                }

            } catch (error) {
                showToast('toast-error', 'Unable to process request. Please try again.');
                console.log("An error occurred:", error);
            }
        }
    </script>

    <script>
        function profileTabHandler() {
            return {
                activeTab: new URLSearchParams(window.location.search).get('tab') || 'profile',
                setTab(tab) {
                    this.activeTab = tab;
                    const url = new URL(window.location.href);
                    url.searchParams.set('tab', tab);
                    window.history.replaceState(null, '', url);
                }
            }
        }
    </script>
</x-layout>