<div
    x-data="formRules()"
    class="space-y-4">
    <!-- Change Password -->
    <form
        id="ChangePasswordForm"
        method="POST"
        action="{{ route('users.updatePassword', $profile->user_id) }}"
        @submit.prevent="UpdatePassword"
        class="grid grid-cols-1 gap-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="grid grid-cols-1 gap-y-6">
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-800">Change Password</h3>

            <!-- Fields -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6">
                <!-- Password -->
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-6 sm:col-span-6">
                    <x-forms.field-container class="sm:col-span-12">
                        <x-forms.label
                            for="current_password">
                            Current Password
                        </x-forms.label>
                        <x-forms.input
                            type="password"
                            id="current_password"
                            name="current_password"
                            autocomplete="off" />
                        <x-forms.error name="current_password" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-12">
                        <x-forms.label
                            for="password">
                            New Password
                        </x-forms.label>
                        <x-forms.input
                            type="password"
                            id="password"
                            name="password"
                            x-model="form.password"
                            :old="old('password')"
                            autocomplete="off" />
                        <x-forms.error name="password" />
                    </x-forms.field-container>

                    <x-forms.field-container class="sm:col-span-12">
                        <x-forms.label
                            for="password_confirmation">
                            Confirm Password
                        </x-forms.label>
                        <x-forms.input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            :old="old('password_confirmation')"
                            autocomplete="off" />
                        <x-forms.error name="password_confirmation" />
                    </x-forms.field-container>
                </div>

                <!-- Password Requirements -->
                <div class="sm:col-span-6">
                    <div class="flex flex-col items-start">
                        <x-forms.label class="mb-2">New password must contain:</x-forms.label>

                        <template x-for="rule in rules" :key="rule.id">
                            <div class="flex items-center mb-2">
                                <div class="w-6 h-6 mr-2 text-green-600" x-show="rule.check(form.password)">
                                    <!-- Check icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <div class="w-6 h-6 mr-2 text-gray-400" x-show="!rule.check(form.password)">
                                    <!-- Dash icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600" x-text="rule.label"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="action-buttons">
                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6">
                    <x-forms.primary-button
                        type="submit"
                        @click="UpdatePassword($event)">
                        Save
                    </x-forms.primary-button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function formRules() {
        return {
            form: {
                password: ''
            },
            rules: [{
                    id: 'length',
                    label: 'At least 8 characters',
                    check: password => password.length >= 8
                },
                {
                    id: 'lowercase',
                    label: 'At least one lowercase letter',
                    check: password => /[a-z]/.test(password)
                },
                {
                    id: 'uppercase',
                    label: 'At least one uppercase letter',
                    check: password => /[A-Z]/.test(password)
                },
                {
                    id: 'number',
                    label: 'At least one number',
                    check: password => /[0-9]/.test(password)
                },
                {
                    id: 'special',
                    label: 'At least one special character',
                    check: password => /[^A-Za-z0-9]/.test(password)
                }
            ]
        }
    }
</script>

<script>
    async function UpdatePassword(event) {
        const form = document.getElementById('ChangePasswordForm');
        const formData = new FormData(form);

        // Clear existing error messages
        clearErrorMessages();

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