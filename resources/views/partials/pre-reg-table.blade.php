<table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-primary">
        <tr>
            <th scope="col" class="py-3 pl-3.5 font-semibold text-gray-900 text-white text-sm text-left sm:pl-6">Name</th>
            <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden lg:table-cell">Pre-Registration Code</th>
            <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-left hidden sm:table-cell">Sex</th>
            <th scope="col" class="px-3 py-3.5 font-semibold text-gray-900 text-white text-sm text-center">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
        @forelse($data as $item)
            <tr>
                <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                    {{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}
                    <dl class="font-normal lg:hidden">
                        <dd class="mt-1 truncate text-gray-700">{{ $item->pre_registration_code }}</dd>
                        <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ $item->sex }}</dd>
                    </dl>
                </td>
                <td class="px-3 py-4 text-sm text-gray-500 text-left hidden lg:table-cell">{{ $item->pre_registration_code }}</td>
                <td class="px-3 py-4 text-sm text-gray-500 text-left hidden sm:table-cell">{{ $item->sex }}</td>
                <td class="px-3 py-4 text-sm text-gray-500 text-center font-medium sm:pr-6 space-x-4">
                    <a href="#" class="text-indigo-500">Edit</a>
                    <a href="#" class="text-red-500">Delete</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="py-4 px-4 text-sm text-center text-gray-500">No results found</td>
            </tr>
        @endforelse
    </tbody>
</table>
