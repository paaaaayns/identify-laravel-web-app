@props([
'title' => 'N/A',
'totalCount' => '0',
'hasView' => true,
'hasCreate' => true,
'viewLink' => '#',
'createLink' => '#'
])

<div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
    <dt>
        <div class="absolute rounded-md bg-primary p-3">
            {{ $slot }}
        </div>
        <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ $title }}</p>
    </dt>
    <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
        <p class="text-2xl font-semibold text-gray-900"> {{ $totalCount }} </p>

        <div class="absolute inset-x-0 bottom-0 bg-secondary px-4 py-4 sm:px-6">
            <div class="text-sm flex space-x-4 ">
                @if ($hasView)
                <a href="{{ $viewLink }}" class="font-medium text-primary hover:text-primary">
                    View all
                </a>
                @endif

                @role(['admin'])
                @if ($hasCreate)
                <a href="{{ $createLink }}" class="font-medium text-primary hover:text-primary">
                    Create
                </a>
                @endif
                @endrole
            </div>
        </div>
    </dd>
</div>