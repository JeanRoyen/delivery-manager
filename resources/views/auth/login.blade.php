<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>
<body class="bg-white dark:bg-zinc-800 flex min-h-screen">
<body class="bg-white dark:bg-zinc-800 flex min-h-screen">
<div class="w-full lg:w-[40%] flex flex-col justify-center px-6 lg:px-16">
    <h2 class="text-3xl font-bold mb-8 text-center">
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

            <flux:navmenu>
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
</body>

@livewireScripts
@fluxScripts
</body>
</html>


