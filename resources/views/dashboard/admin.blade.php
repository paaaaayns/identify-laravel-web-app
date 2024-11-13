<x-layout>
    <div>
        <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-2">

            <x-card-counter :title="'Pre-Registered Patients'" :value="'71,897'" href="#">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </x-card-counter>

            <x-card-counter :title="'Registered Patients'" :value="'71,897'" href="#">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </x-card-counter>

            <x-card-counter :title="'OPDs'" :value="'71,897'" href="#">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </x-card-counter>

            <x-card-counter :title="'Doctors'" :value="'71,897'" href="#">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </x-card-counter>
        </dl>
    </div>



    <div class="pt-10">
        <form class="grid grid-cols-3 gap-4">
            @csrf

            <div class="col-span-1">
                <x-forms.select>
                    <option selected>Select Account Type</option>
                    <option value="">Pre-Registered Patients</option>
                    <option value="">Registered Patients</option>
                    <option value="">Doctors</option>
                    <option value="">Opds</option>
                </x-forms.select>
            </div>

            <div class="col-span-1">
                <x-forms.input type="text" id="first_name" placeholder="Name" required />
            </div>

            <div class="col-span-1">
                <x-forms.primary-button class="h-full">
                    Search
                </x-forms.primary-button>
            </div>
        </form>




        <div class="flow-root mt-6 md:pt-0">
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