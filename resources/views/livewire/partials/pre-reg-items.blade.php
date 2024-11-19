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