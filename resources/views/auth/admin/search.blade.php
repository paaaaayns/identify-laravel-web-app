<x-layout>
    <div>
        <form method="POST" action="/search" class="grid grid-cols-12 gap-6">
            @csrf

            <div class="col-span-12 sm:col-span-5">
                <x-forms.input type="text" name="name" id="name"  placeholder="Name" value="{{ $name ?? '' }}" />
            </div>

            <div class="col-span-12 sm:col-span-5">
                <x-forms.select id="account_type" name="account_type">
                    <option value="PRE-REGISTERED" selected>Pre-Registered Patients</option>
                    <option value="REGISTERED">Registered Patients</option>
                    <option value="DOCTOR">Doctors</option>
                    <option value="OPD">Opds</option>
                </x-forms.select>
            </div>



            <div class="col-span-12 sm:col-span-2">
                <x-forms.primary-button class="h-full w-full" id="search_button">
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
                                    <th scope="col" class="py-3 pl-3.5 font-semibold text-gray-900 text-white text-sm text-left sm:pl-6">
                                        <span class="hidden lg:table-cell">UID</span>
                                        <span class="table-cell lg:hidden">Name</span>
                                    </th>
                                    <th scope="col" class="py-3 pl-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden lg:table-cell">Name</th>
                                    <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden sm:table-cell">Type</th>
                                    <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden sm:table-cell">Room</th>
                                    <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-center">Actions</th>
                                </tr>
                            </thead>



                            <tbody class="divide-y divide-gray-200 bg-white">
                                @if($data && $data->count() > 0)
                                <!-- Loop through the $data and display each item -->
                                @foreach($data as $item)
                                <tr>
                                    <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                        <dl class="font-normal lg:hidden">
                                            <dd class="mb-1 truncate text-gray-700">{{ $item->user_id }}</dd>
                                        </dl>
                                        <span class="hidden lg:table-cell">{{ $item->user_id }}</span>
                                        <span class="table-cell lg:hidden">{{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}</span>
                                        <dl class="font-normal lg:hidden">
                                            <dd class="mt-1 truncate text-gray-700 sm:hidden">{{ $item->type }}</dd>
                                            <!-- <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ $item->room }}</dd> -->
                                            <dd class="mt-1 truncate text-gray-500 sm:hidden">test</dd>
                                        </dl>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 text-left hidden lg:table-cell">{{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-500 text-left hidden sm:table-cell">{{ $item->type }}</td>
                                    <!-- <td class="px-3 py-4 text-sm text-gray-500 text-left hidden sm:table-cell">{{ $item->room }}</td> -->
                                    <td class="px-3 py-4 text-sm text-gray-500 text-left hidden sm:table-cell">test</td>
                                    <td class="px-3 py-4 text-sm text-gray-500 text-center font-medium sm:pr-6 space-x-4">
                                        <a href="#" class="text-indigo-500">Edit</a>
                                        <a href="#" class="text-red-500">Delete</a>
                                    </td>
                                </tr>
                                @endforeach

                                <!-- More people... -->

                                @else
                                <!-- Display a message if no data is available -->
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center text-gray-500 py-4">No records found.</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>