<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    <!-- Livewire Assets -->
   @livewireStyles

    <!-- Flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <!-- SweelAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="h-screen flex">
    <!-- Left Division -->
    <div class="fixed inset-y-0 w-1/3 z-50 hidden sm:flex flex-col items-center justify-center bg-background-dark text-white">
        <h1 class="text-2xl">Left Side Content</h1>
    </div>

    <!-- Right Division -->
    <div class="bg-background-light sm:ml-auto w-full sm:w-2/3 pl-4 overflow-y-auto py-10 px-4 sm:px-6 lg:px-10">

    {{ $slot }}
    
    </div>
</body>

</html>