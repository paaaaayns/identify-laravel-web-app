<x-layout>
    <div>
        <form class="grid grid-cols-12 gap-4">
            @csrf

            <div class="col-span-12 sm:col-span-5">
                <x-forms.select id="account_type" name="account_type">
                    <option value="PRE-REGISTERED" selected>Pre-Registered Patients</option>
                    <option value="REGISTERED">Registered Patients</option>
                    <option value="DOCTOR">Doctors</option>
                    <option value="OPD">Opds</option>
                </x-forms.select>
            </div>

            <div class="col-span-12 sm:col-span-5">
                <x-forms.input type="text" id="name" placeholder="Name" required />
            </div>

            <div class="col-span-12 sm:col-span-2">
                <x-forms.primary-button class="h-full w-full">
                    Search
                </x-forms.primary-button>
            </div>
        </form>


        <div id="dataTableContainer" class="flow-root mt-6 md:pt-0">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle px-3 sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-primary">
                                <tr>
                                    <th scope="col" class="py-3 pl-3.5 font-semibold text-gray-900 text-white text-sm text-left sm:pl-6">Name</th>
                                    <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden lg:table-cell">Type</th>
                                    <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden sm:table-cell">Room</th>
                                    <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">

                                <tr>
                                    <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                        Lindsay Walton
                                        <dl class="font-normal lg:hidden">
                                            <dd class="mt-1 truncate text-gray-700">Neuro Surgeon</dd>
                                            <dd class="mt-1 truncate text-gray-500 sm:hidden">A-102</dd>
                                        </dl>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 text-left hidden lg:table-cell">Neuro Surgeon</td>
                                    <td class="px-3 py-4 text-sm text-gray-500 text-left hidden sm:table-cell">A-102</td>
                                    <td class="px-3 py-4 text-sm text-gray-500 text-center font-medium sm:pr-6 space-x-4">
                                        <a href="#" class="text-indigo-500">Edit</a>
                                        <a href="#" class="text-red-500">Delete</a>
                                    </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>