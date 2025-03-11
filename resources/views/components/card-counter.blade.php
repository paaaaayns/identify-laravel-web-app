@props([
'title' => 'N/A',
'totalCount' => '0',
'recentCount' => '0',
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

        @if ($recentCount > 0)
        <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
            <svg class="h-5 w-5 shrink-0 self-center text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z" clip-rule="evenodd" />
            </svg>
            <span class="sr-only"> Increased by </span>
            {{ $recentCount }}
        </p>
        @endif

        <div class="absolute inset-x-0 bottom-0 bg-secondary px-4 py-4 sm:px-6">
            <div class="text-sm flex space-x-4 ">
                @if ($hasView)
                <a href="{{ $viewLink }}" class="font-medium text-primary hover:text-primary">
                    View all
                </a>
                @endif

                @if ($hasCreate)
                <a href="{{ $createLink }}" class="font-medium text-primary hover:text-primary">
                    Create
                </a>
                @endif
            </div>
        </div>
    </dd>
</div>