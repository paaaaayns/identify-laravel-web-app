<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <!-- logo, located in /resources/assets/logo -->
   <link rel="icon" type="image/png" href="{{ asset('images/logo/favicon-dark.png') }}">

   <title>iDentify</title>
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
   <div
      x-data="{ isSideNavOpen: false }">
      <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
      <div
         x-show="isSideNavOpen"
         role="dialog"
         aria-modal="true"
         class="relative z-50 lg:hidden w-full">

         <!-- Off-canvas menu overlay, show/hide based on off-canvas menu state. -->
         <div
            x-show="isSideNavOpen"
            @click="isSideNavOpen = false"
            aria-hidden="true"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/80 w-full h-full ">
         </div>


         <div
            x-show="isSideNavOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-0 flex w-64">

            <!-- Off-canvas menu -->
            <div
               x-show="isSideNavOpen"
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="relative w-full flex bg-white px-6 py-6">


               <!-- Sidebar component, swap this element with another sidebar if you like -->
               <div class="flex flex-col w-full">
                  <div class="flex h-auto items-center ">
                     <a href="/dashboard">
                        <img class="h-10 w-auto" src="{{ asset('images/logo/primary-vertical-dark.png') }}" alt="Your Company">
                     </a>
                  </div>
                  <nav class="flex flex-1 flex-col">
                     <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                           <x-side-nav />
                        </li>
                        <li class="-mx-6 mt-auto">
                           <a href="/profile" class="flex items-center gap-x-4 px-6 pt-3 text-sm/6 font-semibold text-gray-900 hover:bg-gray-50">
                              <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                              <span class="sr-only">Your profile</span>
                              <!-- name and role on top of each other -->
                              <div class="flex flex-col">
                                 <span aria-hidden="true">{{ $user->first_name }} {{ $user->last_name }}</span>
                                 <span aria-hidden="true" class="text-xs/6 text-gray-500">{{ ucfirst($user->role) }}</span>
                              </div>
                           </a>
                        </li>
                     </ul>
                  </nav>
               </div>

            </div>
         </div>
      </div>

      <!-- Static sidebar for desktop -->
      <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
         <!-- Sidebar component, swap this element with another sidebar if you like -->
         <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 py-6">
            <div class="flex h-auto items-center ">
               <a href="/dashboard">
                  <img class="h-10 w-auto" src="{{ asset('images/logo/primary-vertical-dark.png') }}" alt="Your Company">
               </a>
            </div>
            <nav class="flex flex-1 flex-col">
               <ul role="list" class="flex flex-1 flex-col gap-y-7">
                  <li>
                     <x-side-nav />
                  </li>
                  <li class="-mx-6 mt-auto">
                     <a href="/profile" class="flex items-center gap-x-4 px-6 pt-3 text-sm/6 font-semibold text-gray-900 hover:bg-gray-50">
                        <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        <span class="sr-only">Your profile</span>
                        <!-- name and role on top of each other -->
                        <div class="flex flex-col">
                           <span aria-hidden="true">{{ $user->first_name }} {{ $user->last_name }}</span>
                           <span aria-hidden="true" class="text-xs/6 text-gray-500">{{ ucfirst($user->role) }}</span>
                        </div>
                     </a>
                  </li>
               </ul>
            </nav>
         </div>
      </div>

      <!-- topbar -->
      <div class="lg:pl-64">
         <div
            class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <button
               @click="isSideNavOpen = true"
               type="button"
               class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
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
                  <!-- Profile dropdown -->
                  <div
                     x-data="{ isOpen: false }"
                     class="relative">
                     <button
                        @click="isOpen = !isOpen"
                        @click.outside="isOpen = false"
                        type="button"
                        id="user-menu-button"
                        class="-m-1.5 p-1.5"
                        aria-expanded="false"
                        aria-haspopup="true"
                        aria-controls="profile-menu"
                        :aria-expanded="isOpen">
                        <span class="sr-only">Open user menu</span>
                        <div class="flex items-center gap-x-2">
                           <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                           <span class="text-sm/6 font-semibold text-gray-900" aria-hidden="true"> {{ $user->first_name }} {{ $user->last_name }} </span>
                           <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                              <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                           </svg>
                        </div>
                     </button>

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
                        <a href="/profile" class="block px-3 py-1 text-sm/6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-0">Your profile</a>
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