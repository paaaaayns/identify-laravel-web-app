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

<body class="min-h-screen flex flex-row p-0 m-0">
    <!-- Left Division -->
    <div class="flex flex-grow min-w-1/2 max-w-1/2 items-center justify-center bg-background-dark">
        <div class="text-center">
            <h1 class="text-white text-2xl">Left Side Content</h1>
        </div>
    </div>

    <!-- Right Division -->
    <div class="flex flex-grow min-w-1/2 max-w-1/2 items-center justify-center bg-background-light">
        <div class="text-center">

            {{ $slot }}

        </div>
    </div>
</body>

</html>