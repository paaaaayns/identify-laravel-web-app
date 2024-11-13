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

<body class="h-screen flex flex-row p-0 m-0">
    <!-- Left Division -->
    <div class="flex flex-grow min-w-1/2 max-w-1/2 items-center justify-center bg-background-dark">
        <div class="text-center">
            <h1 class="text-white text-2xl">Left Side Content</h1>
        </div>
    </div>

    <!-- Right Division -->
    <div class="flex flex-grow min-w-1/2 max-w-1/2 items-center justify-center bg-background-light">
        <div class="text-center">
            <form method="POST" action="/login">
                @csrf

                <x-forms.error name="test" />

                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-12">
                    <x-forms.field>
                        <x-forms.label>Email</x-forms.label>

                        <x-forms.input type="text" name="email" id="email" :value="old('email')" autocomplete="off" class="mt-2" />
                        <x-forms.error name="email" />
                    </x-forms.field>

                    <x-forms.field>
                        <x-forms.label>Password</x-forms.label>

                        <x-forms.input type="password" name="password" id="password" autocomplete="off" class="mt-2" />
                        <x-forms.error name="password" />
                    </x-forms.field>
                </div>

                <div class="mt-6 flex items-center justify-center gap-x-6">
                    <x-forms.primary-button type="submit">Login</x-button>
                </div>

                <p class="mt-6">
                    Not registered yet? <a href="" class="text-primary">Register Now</a>
                </p>

                <p class="mt-6">
                    <a href="" class="text-primary">Forget Password?</a>
                </p>
            </form>

        </div>
    </div>
</body>

</html>