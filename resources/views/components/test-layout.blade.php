<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen flex">
    <!-- Left Division -->
    <div class="fixed inset-y-0 w-1/3 z-50 flex flex-col items-center justify-center bg-background-dark text-white">
        <h1 class="text-2xl">Left Side Content</h1>
    </div>

    <!-- Right Division -->
    <div class="bg-background-light ml-auto w-2/3 pl-4 overflow-y-auto py-10 px-4 sm:px-6 lg:px-10">
        <div class="">
            {{ $slot }}
        </div>
    </div>
</body>


</html>