<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Delivery Manager | {{ __('pages_title.login') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<h1 class="sr-only">Delivery Manager | {{ __('pages_title.login') }}</h1>

<main
    class="flex min-h-screen w-full"
    aria-labelledby="login-title"
    title="Delivery Manager"
>
    <div class="w-full lg:w-[40%] flex flex-col justify-center px-6 lg:px-16">
        <h2 id="login-title" class="text-3xl font-bold mb-8 text-center">
            Delivery Manager
        </h2>

        <flux:card class="space-y-6">
            <div>
                <flux:heading size="xl">
                    {{ __('auth_form.login_title') }}
                </flux:heading>
            </div>

            <div>
                <x-auth.form />
            </div>
        </flux:card>

        <div class="mt-6 flex justify-center lg:justify-start">
            <flux:dropdown>
                <flux:button icon:trailing="chevron-down">
                    {{ language()->getName() }}
                </flux:button>

                <flux:navmenu
                    aria-label="{{ __('sidebar.language_navigation') }}"
                >
                    <h2 class="sr-only">{{ __('sidebar.language_navigation') }}</h2>

                    @foreach (language()->allowed() as $code => $name)
                        <flux:navmenu.item href="{{ language()->back($code) }}">
                            {{ $name }}
                        </flux:navmenu.item>
                    @endforeach
                </flux:navmenu>
            </flux:dropdown>
        </div>
    </div>

    <div class="hidden lg:block lg:w-[60%] h-screen">
        <img
            src="{{ asset('img/login_image.webp') }}"
            alt="{{ __('auth_form.delivery_driver_alt') }}"
            class="w-full h-full object-cover"
        >
    </div>
</main>
@livewireScripts
@fluxScripts
</body>
</html>
