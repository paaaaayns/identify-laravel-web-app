<!-- 
    Current: 
        a: "bg-background-dark text-white"
        svg: ""text-white
    Default: 
        a: "text-gray-700 hover:bg-gray-50" 
        svg: "text-gray-400"
-->

@role(['admin'])
<ul role="list" class="-mx-2 space-y-1">

    <!-- Dashboard -->
    <li>
        <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
            <h2 class="text-sm/6 text-gray-700">
                Dashboard
            </h2>
        </div>
    </li>

    <!-- Dashboard -->
    <li x-data="{ isActive: window.location.pathname.startsWith('/dashboard') }">
        <a
            href="/dashboard"
            :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
            <svg
                :class="isActive ? 'text-white' : 'text-gray-400'"
                class="h-6 w-6 shrink-0 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>
    </li>

    <!-- Users -->
    <li>
        <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
            <h2 class="text-sm/6 text-gray-700">
                Users
            </h2>
        </div>
    </li>

    <!-- Pre-Registered Patients -->
    <li>
        <div x-data="{ isOpen: window.location.pathname.startsWith('/users/pre-reg') }">
            <button
                @click="isOpen = !isOpen"
                type="button"
                class="flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold text-gray-700 hover:bg-gray-50"
                :aria-expanded="isOpen"
                aria-controls="sub-menu-1">
                <svg
                    class="h-6 w-6 shrink-0 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Pre-Registered Patients
                <svg
                    :class="isOpen ? 'rotate-90 text-gray-500' : 'text-gray-400'"
                    class="ml-auto h-5 w-5 shrink-0 transition-transform duration-200"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        fill-rule="evenodd"
                        d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul
                x-show="isOpen"
                x-cloak
                class="mt-1 px-2"
                id="sub-menu-1">
                <li x-data="{ isActive: window.location.pathname === '/users/pre-reg' }">
                    <a href="{{ route('users.pre-reg.index') }}"
                        :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                        class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                        List
                    </a>
                </li>
                <li x-data="{ isActive: window.location.pathname === '/users/pre-reg/create' }">
                    <a href="{{ route('users.pre-reg.create') }}"
                        :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                        class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                        Create
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Registered Patients -->
    <li>
        <div x-data="{ isOpen: window.location.pathname.startsWith('/users/patient') }">
            <button
                @click="isOpen = !isOpen"
                type="button"
                class="flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold text-gray-700 hover:bg-gray-50"
                :aria-expanded="isOpen"
                aria-controls="sub-menu-1">
                <svg
                    class="h-6 w-6 shrink-0 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Registered Patients
                <svg
                    :class="isOpen ? 'rotate-90 text-gray-500' : 'text-gray-400'"
                    class="ml-auto h-5 w-5 shrink-0"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        fill-rule="evenodd"
                        d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul
                x-show="isOpen"
                x-cloak
                class="mt-1 px-2"
                id="sub-menu-1">
                <li x-data="{ isActive: window.location.pathname === '/users/patient' }">
                    <a href="{{ route('users.patient.index') }}"
                        :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                        class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                        List
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- OPDs -->
    <li>
        <div x-data="{ isOpen: window.location.pathname.startsWith('/users/opd') }">
            <button
                @click="isOpen = !isOpen"
                type="button"
                class="flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold text-gray-700 hover:bg-gray-50"
                :aria-expanded="isOpen"
                aria-controls="sub-menu-1">
                <svg
                    class="h-6 w-6 shrink-0 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                OPDs
                <svg
                    :class="isOpen ? 'rotate-90 text-gray-500' : 'text-gray-400'"
                    class="ml-auto h-5 w-5 shrink-0"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        fill-rule="evenodd"
                        d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul
                x-show="isOpen"
                x-cloak
                class="mt-1 px-2"
                id="sub-menu-1">
                <li x-data="{ isActive: window.location.pathname === '/users/opd' }">
                    <a href="{{ route('users.opd.index') }}"
                        :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                        class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                        List
                    </a>
                </li>
                <li x-data="{ isActive: window.location.pathname === '/users/opd/create' }">
                    <a href="{{ route('users.opd.create') }}"
                        :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                        class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                        Create
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Doctors -->
    <li>
        <div x-data="{ isOpen: window.location.pathname.startsWith('/users/doctor') }">
            <button
                @click="isOpen = !isOpen"
                type="button"
                class="flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold text-gray-700 hover:bg-gray-50"
                :aria-expanded="isOpen"
                aria-controls="sub-menu-1">
                <svg
                    class="h-6 w-6 shrink-0 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Doctors
                <svg
                    :class="isOpen ? 'rotate-90 text-gray-500' : 'text-gray-400'"
                    class="ml-auto h-5 w-5 shrink-0"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                    data-slot="icon">
                    <path
                        fill-rule="evenodd"
                        d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>

            <ul
                x-show="isOpen"
                x-cloak
                class="mt-1 px-2"
                id="sub-menu-1">
                <li x-data="{ isActive: window.location.pathname === '/users/doctor' }">
                    <a href="{{ route('users.doctor.index') }}"
                        :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                        class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                        List
                    </a>
                </li>
                <li x-data="{ isActive: window.location.pathname === '/users/doctor/create' }">
                    <a href="{{ route('users.doctor.create') }}"
                        :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                        class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                        Create
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Queues -->
    <li>
        <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
            <h2 class="text-sm/6 text-gray-700">Queues</h2>
        </div>
    </li>

    <!-- Queued Patients -->
    <li x-data="{ isActive: window.location.pathname.startsWith('/queue') }">
        <a
            href="{{ route('queue.index') }}"
            :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
            <svg
                :class="isActive ? 'text-white' : 'text-gray-400'"
                class="h-6 w-6 shrink-0 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
            </svg>
            Queued Patients
        </a>
    </li>

</ul>
@endrole


@role(['opd'])
<ul role="list" class="-mx-2 space-y-1">

    <!-- Dashboard -->
    <li>
        <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
            <h2 class="text-sm/6 text-gray-700">
                Dashboard
            </h2>
        </div>
    </li>
    
    <!-- Dashboard -->
    <li x-data="{ isActive: window.location.pathname.startsWith('/dashboard') }">
        <a
            href="/dashboard"
            :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
            <svg
                :class="isActive ? 'text-white' : 'text-gray-400'"
                class="h-6 w-6 shrink-0 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>
    </li>

    <!-- Users -->
    <li>
        <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
            <h2 class="text-sm/6 text-gray-700">
                Patients
            </h2>
        </div>
    </li>

    <!-- Pre-Registered Patients -->
    <li x-data="{ isActive: window.location.pathname.startsWith('/users/pre-reg') }">
        <a
            href="{{ route('users.pre-reg.index') }}"
            :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
            <svg
                :class="isActive ? 'text-white' : 'text-gray-400'"
                class="h-6 w-6 shrink-0 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            Pre-Registered
        </a>
    </li>

    <!-- Registered Patients -->
    <li x-data="{ isActive: window.location.pathname.startsWith('/users/patient') }">
        <a
            href="{{ route('users.patient.index') }}"
            :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
            <svg
                :class="isActive ? 'text-white' : 'text-gray-400'"
                class="h-6 w-6 shrink-0 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
            Patients
        </a>
    </li>

    <!-- Queues -->
    <li>
        <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
            <h2 class="text-sm/6 text-gray-700">Queues</h2>
        </div>
    </li>

    <!-- Queued Patients -->
    <li x-data="{ isActive: window.location.pathname.startsWith('/queue') }">
        <a
            href="{{ route('queue.index') }}"
            :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
            <svg
                :class="isActive ? 'text-white' : 'text-gray-400'"
                class="h-6 w-6 shrink-0 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
            </svg>
            Queued Patients
        </a>
    </li>

</ul>
@endrole


@role(['doctor'])
<ul role="list" class="-mx-2 space-y-1">

    <!-- Dashboard -->
    <li>
        <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
            <h2 class="text-sm/6 text-gray-700">
                Dashboard
            </h2>
        </div>
    </li>
    
    <!-- Dashboard -->
    <li x-data="{ isActive: window.location.pathname.startsWith('/dashboard') }">
        <a
            href="/dashboard"
            :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
            <svg
                :class="isActive ? 'text-white' : 'text-gray-400'"
                class="h-6 w-6 shrink-0 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>
    </li>

    <!-- Queues -->
    <li>
        <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
            <h2 class="text-sm/6 text-gray-700">Queues</h2>
        </div>
    </li>

    <!-- Queued Patients -->
    <li x-data="{ isActive: window.location.pathname.startsWith('/queue') }">
        <a
            href="{{ route('queue.index') }}"
            :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold">
            <svg
                :class="isActive ? 'text-white' : 'text-gray-400'"
                class="h-6 w-6 shrink-0 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                aria-hidden="true"
                data-slot="icon">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
            </svg>
            Queued Patients
        </a>
    </li>

</ul>
@endrole