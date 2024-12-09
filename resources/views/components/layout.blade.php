<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>Document</title>
   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

   <!-- Styles / Scripts -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])

   <!-- Livewire Styles -->
   @livewireStyles

   <!-- Flowbite -->
   <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

   <!-- SweelAlert2 -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <style>
      [x-cloak] {
         display: none !important;
      }
   </style>
</head>

<body class="h-full">
   <!--
   This example requires some changes to your config:
   
   ```
   // tailwind.config.js
   module.exports = {
      // ...
      plugins: [
         // ...
         require('@tailwindcss/forms'),
      ],
   }
   ```
   -->
   <!--
   This example requires updating your template:

   ```
   <html class="h-full bg-white">
   <body class="h-full">
   ```
   -->
   <div>
      <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
      <div
         x-data="{ isOpen: false }"
         role="dialog"
         aria-modal="true"
         class="relative z-50 lg:hidden">
         <!--
            Off-canvas menu backdrop, show/hide based on off-canvas menu state.

            Entering: "transition-opacity ease-linear duration-300"
            From: "opacity-0"
            To: "opacity-100"
            Leaving: "transition-opacity ease-linear duration-300"
            From: "opacity-100"
            To: "opacity-0"
         -->
         <div
            x-show="isOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="isOpen = false"
            aria-hidden="true"
            class="fixed inset-0 bg-gray-900/80">
         </div>

         <div
            x-show="isOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-0 flex">
            <!--
            Off-canvas menu, show/hide based on off-canvas menu state.

            Entering: "transition ease-in-out duration-300 transform"
               From: "-translate-x-full"
               To: "translate-x-0"
            Leaving: "transition ease-in-out duration-300 transform"
               From: "translate-x-0"
               To: "-translate-x-full"
            -->
            <div
               x-show="isOpen"
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="relative mr-16 flex w-full max-w-xs flex-1 bg-white">
               <!--
                  Close button, show/hide based on off-canvas menu state.

                  Entering: "ease-in-out duration-300"
                     From: "opacity-0"
                     To: "opacity-100"
                  Leaving: "ease-in-out duration-300"
                     From: "opacity-100"
                     To: "opacity-0"
               -->
               <div
                  x-show="isOpen"
                  x-transition:enter="ease-in-out duration-300"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="ease-in-out duration-300"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0"
                  class="absolute left-full top-0 flex w-16 justify-center pt-5">

                  <button
                     @click="isOpen = false"
                     type="button"
                     class="-m-2.5 p-2.5">
                     <span class="sr-only">Close sidebar</span>
                     <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                     </svg>
                  </button>
               </div>

               <!-- Sidebar component, swap this element with another sidebar if you like -->
               <div
                  x-show="isOpen"
                  class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
                  <div class="flex h-16 shrink-0 items-center">
                     <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                  </div>
                  <nav class="flex flex-1 flex-col">
                     <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                           <ul role="list" class="-mx-2 space-y-1">
                              <li>
                                 <!-- Current: "bg-gray-50", Default: "hover:bg-gray-50" -->
                                 <a href="#" class="group flex gap-x-3 rounded-md bg-gray-50 p-2 text-sm/6 font-semibold text-gray-700">
                                    <svg class="h-6 w-6 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                    Dashboard
                                 </a>
                              </li>
                              <li>
                                 <div x-data="{ isOpen: false }">
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
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                       </svg>
                                       Teams
                                       <svg
                                          :class="isOpen ? 'rotate-90 text-gray-500' : 'text-gray-400'"
                                          class="ml-auto h-5 w-5 shrink-0"
                                          viewBox="0 0 20 20"
                                          fill="currentColor"
                                          aria-hidden="true"
                                          data-slot="icon">
                                          <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                       </svg>
                                    </button>

                                    <ul
                                       x-show="isOpen"
                                       x-cloak
                                       class="mt-1 px-2"
                                       id="sub-menu-1">
                                       <li><a href="#" class="block rounded-md py-2 pl-9 pr-2 text-sm/6 text-gray-700 hover:bg-gray-50">Engineering</a></li>
                                       <li><a href="#" class="block rounded-md py-2 pl-9 pr-2 text-sm/6 text-gray-700 hover:bg-gray-50">Human Resources</a></li>
                                       <li><a href="#" class="block rounded-md py-2 pl-9 pr-2 text-sm/6 text-gray-700 hover:bg-gray-50">Customer Success</a></li>
                                    </ul>
                                 </div>
                              </li>
                              <li>
                                 <div>
                                    <button type="button" class="flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm/6 font-semibold text-gray-700 hover:bg-gray-50" aria-controls="sub-menu-2" aria-expanded="false">
                                       <svg class="h-6 w-6 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                       </svg>
                                       Projects
                                       <!-- Expanded: "rotate-90 text-gray-500", Collapsed: "text-gray-400" -->
                                       <svg class="ml-auto h-5 w-5 shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                          <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                       </svg>
                                    </button>
                                    <!-- Expandable link section, show/hide based on state. -->
                                    <ul class="mt-1 px-2" id="sub-menu-2">
                                       <li>
                                          <!-- 44px -->
                                          <a href="#" class="block rounded-md py-2 pl-9 pr-2 text-sm/6 text-gray-700 hover:bg-gray-50">GraphQL API</a>
                                       </li>
                                       <li>
                                          <!-- 44px -->
                                          <a href="#" class="block rounded-md py-2 pl-9 pr-2 text-sm/6 text-gray-700 hover:bg-gray-50">iOS App</a>
                                       </li>
                                       <li>
                                          <!-- 44px -->
                                          <a href="#" class="block rounded-md py-2 pl-9 pr-2 text-sm/6 text-gray-700 hover:bg-gray-50">Android App</a>
                                       </li>
                                       <li>
                                          <!-- 44px -->
                                          <a href="#" class="block rounded-md py-2 pl-9 pr-2 text-sm/6 text-gray-700 hover:bg-gray-50">New Customer Portal</a>
                                       </li>
                                    </ul>
                                 </div>
                              </li>
                              <li>
                                 <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50">
                                    <svg class="h-6 w-6 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    Calendar
                                 </a>
                              </li>
                              <li>
                                 <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50">
                                    <svg class="h-6 w-6 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                    </svg>
                                    Documents
                                 </a>
                              </li>
                              <li>
                                 <a href="#" class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50">
                                    <svg class="h-6 w-6 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                    </svg>
                                    Reports
                                 </a>
                              </li>
                           </ul>
                        </li>
                        <li class="-mx-6 mt-auto">
                           <a href="#" class="flex items-center gap-x-4 px-6 py-3 text-sm/6 font-semibold text-gray-900 hover:bg-gray-50">
                              <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                              <span class="sr-only">Your profile</span>
                              <span aria-hidden="true">{{ $user->first_name }} {{ $user->last_name }}</span>
                           </a>
                        </li>
                     </ul>
                  </nav>
               </div>

            </div>
         </div>
      </div>

      <!-- Static sidebar for desktop -->
      <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
         <!-- Sidebar component, swap this element with another sidebar if you like -->
         <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
            <div class="flex h-16 shrink-0 items-center">
               <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            </div>
            <nav class="flex flex-1 flex-col">
               <ul role="list" class="flex flex-1 flex-col gap-y-7">
                  <li>
                     <ul role="list" class="-mx-2 space-y-1">
                        <!-- 
                           Current: 
                              a: "bg-background-dark text-white"
                              svg: ""text-white
                           Default: 
                              a: "text-gray-700 hover:bg-gray-50" 
                              svg: "text-gray-400"
                        -->

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


                        @if ($user->account_type === 'ADMIN')
                        <li>
                           <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
                              <h2 class="text-sm/6 text-gray-700">Users</h2>
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
                                 <li>

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
                                 <li x-data="{ isActive: window.location.pathname === '/users/patient/create' }">
                                    <a href="{{ route('users.patient.create') }}"
                                       :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                                       class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                                       Create
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
                        @endif

                        @if ($user->account_type === 'OPD')
                        <li>
                           <div class="flex w-full items-center gap-x-3 rounded-md px-2 pt-2 text-left text-sm/6">
                              <h2 class="text-sm/6 text-gray-700">Users</h2>
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
                                 <li>

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
                                 <li x-data="{ isActive: window.location.pathname === '/users/patient/create' }">
                                    <a href="{{ route('users.patient.create') }}"
                                       :class="isActive ? 'bg-background-dark text-white' : 'text-gray-700 hover:bg-gray-50'"
                                       class="block rounded-md py-2 pl-9 pr-2 text-sm/6">
                                       Create
                                    </a>
                                 </li>
                              </ul>
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
                        @endif




                     </ul>
                  </li>
                  <li class="-mx-6 mt-auto">
                     <a href="#" class="flex items-center gap-x-4 px-6 py-3 text-sm/6 font-semibold text-gray-900 hover:bg-gray-50">
                        <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        <span class="sr-only">Your profile</span>
                        <span aria-hidden="true">{{ $user->first_name }} {{ $user->last_name }}</span>
                     </a>
                  </li>
               </ul>
            </nav>
         </div>
      </div>

      <div class="lg:pl-72">
         <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8"
            x-show="isOpen">
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden"
               @click="isOpen = false">
               <span class="sr-only">Open sidebar</span>
               <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
               </svg>
            </button>

            <!-- Separator -->
            <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>


            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
               <div class="flex-1"></div>
               <div class="flex items-center gap-x-4 lg:gap-x-6">
                  <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                     <span class="sr-only">View notifications</span>
                     <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                     </svg>
                  </button>

                  <!-- Separator -->
                  <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div>

                  <!-- Profile dropdown -->
                  <div
                     x-data="{ isOpen: false }"
                     class="relative">
                     <button
                        @click="isOpen = !isOpen"
                        @click.outside="isOpen = false"
                        type="button"
                        id="user-menu-button"
                        class="-m-1.5 flex items-center p-1.5"
                        aria-expanded="false"
                        aria-haspopup="true"
                        aria-controls="profile-menu"
                        :aria-expanded="isOpen">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        <span class="hidden lg:flex lg:items-center">
                           <span class="ml-4 text-sm/6 font-semibold text-gray-900" aria-hidden="true"> {{ $user->first_name }} {{ $user->last_name }} </span>
                           <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                              <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                           </svg>
                        </span>
                     </button>

                     <!--
                     Dropdown menu, show/hide based on menu state.

                     Entering: "transition ease-out duration-100"
                        From: "transform opacity-0 scale-95"
                        To: "transform opacity-100 scale-100"
                     Leaving: "transition ease-in duration-75"
                        From: "transform opacity-100 scale-100"
                        To: "transform opacity-0 scale-95"
                     -->
                     <div
                        id="profile-menu"
                        x-show="isOpen"
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                        role="menu"
                        aria-orientation="vertical"
                        aria-labelledby="user-menu-button"
                        tabindex="-1">
                        <!-- Active: "bg-gray-50 outline-none", Not Active: "" -->
                        <a href="#" class="block px-3 py-1 text-sm/6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-0">Your profile</a>
                        <form method="POST" action="/logout">
                           @csrf
                           <button type="submit" class="block w-full px-3 py-1 text-left text-sm/6 text-gray-900 hover:bg-gray-50" role="menuitem" tabindex="-1">
                              Sign out
                           </button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <main class="py-10 ">
            <div class="px-4 sm:px-6 lg:px-8 ">
               {{ $slot }}
            </div>
         </main>
      </div>
   </div>


   <!-- Success Toast (initially hidden) -->
   <div id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 fixed top-4 left-1/2 transform -translate-x-1/2 z-50 hidden" role="alert">
      <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
         <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
         </svg>
         <span class="sr-only">Check icon</span>
      </div>
      <div class="ms-3 text-sm font-normal" id="toast-success-message">Toast Success Message</div>
      <button
         type="button"
         onclick="hideToast('toast-success')"
         data-dismiss-target="#toast-success"
         aria-label="Close"
         class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
         <span class="sr-only">Close</span>
         <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
         </svg>
      </button>
   </div>

   <!-- Error Toast (initially hidden) -->
   <div id="toast-error" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 fixed top-4 left-1/2 transform -translate-x-1/2 z-50 hidden" role="alert">
      <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
         <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
         </svg>
         <span class="sr-only">Error icon</span>
      </div>
      <div class="ms-3 text-sm font-normal" id="toast-error-message">Toast Failed Message</div>
      <button
         type="button"
         onclick="hideToast('toast-error')"
         data-dismiss-target="#toast-error"
         aria-label="Close"
         class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
         <span class="sr-only">Close</span>
         <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
         </svg>
      </button>
   </div>


   <!-- Livewire Assets -->
   @livewireScripts
</body>

</html>