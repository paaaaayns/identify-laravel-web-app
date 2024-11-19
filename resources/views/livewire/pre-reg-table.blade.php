<div>
    <form id="searchForm" method="POST" action="/search" class="grid grid-cols-12 gap-6">
        @csrf

        <div class="col-span-12 sm:col-span-10">
            <x-forms.input wire:model="search" type="text" name="name" id="name" placeholder="Name" value="{{ $name ?? '' }}" />
        </div>

        <div class="col-span-12 sm:col-span-2">
            <x-forms.primary-button class="h-full w-full" id="search_button">
                Search
            </x-forms.primary-button>
        </div>
    </form>

    <div class="flow-root mt-6 md:pt-0">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle px-3 sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                    <table id="search-table" class="w-full divide-y divide-gray-300">
                        <thead class="bg-primary">
                            <tr>
                                <th scope="col" class="py-3 pl-3.5 font-semibold text-gray-900 text-white text-sm text-left sm:pl-6 hidden lg:table-cell">Code</th>
                                <th scope="col" class="py-3 pl-3.5 font-semibold text-gray-900 text-white text-sm text-left sm:pl-6 table-cell lg:hidden">Name</th>
                                <th scope="col" class="py-3 pl-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden lg:table-cell">Name</th>
                                <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden sm:table-cell">Birthdate</th>
                                <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden sm:table-cell">Sex</th>
                                <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="dataTableBody" class="divide-y divide-gray-200 bg-white">
                            @if($list->count() === 0)
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center text-gray-700 py-4">No records found.</p>
                                    </td>
                                </tr>
                            @else
                                @foreach($list as $item)
                                    <tr>
                                        <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                            <dl class="font-normal lg:hidden">
                                                <dd class="mb-1 truncate text-sm text-gray-700 text-left">{{ $item->pre_registration_code }}</dd>
                                            </dl>
                                            <span class="hidden lg:table-cell">{{ $item->pre_registration_code }}</span>
                                            <span class="table-cell lg:hidden">{{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}</span>
                                            <dl class="font-normal sm:hidden">
                                                <dd class="truncate text-sm text-gray-700 text-left my-1">{{ $item->birthdate }}</dd>
                                                <dd class="truncate text-sm text-gray-700 text-left">{{ $item->sex }}</dd>
                                            </dl>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-700 text-left hidden lg:table-cell">{{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}</td>
                                        <td class="px-3 py-4 text-sm text-gray-700 text-left hidden sm:table-cell">{{ $item->birthdate }}</td>
                                        <td class="px-3 py-4 text-sm text-gray-700 text-left hidden sm:table-cell">{{ $item->sex }}</td>
                                        <td class="px-3 py-4 text-sm text-gray-700 text-center font-medium sm:pr-6 space-x-4">
                                            <a href="#" class="text-primary">View</a>
                                            <a href="#" class="text-indigo-500">Edit</a>
                                            <a href="#" class="text-red-500">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <!-- Pagination Links -->


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>