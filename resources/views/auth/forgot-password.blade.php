<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Delivery Manager | {{ __('pages_title.forgot_password') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon-delivery-manager.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
<main class="flex min-h-screen items-center justify-center px-6 py-12" aria-labelledby="forgot-password-title">
    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <img src="{{ asset('favicon-delivery-manager.png') }}" alt="" class="mx-auto mb-4 size-16 object-contain">
            <h1 id="forgot-password-title" class="text-2xl font-bold text-zinc-900 dark:text-white">
                {{ __('auth_form.forgot_password_title') }}
            </h1>
            <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                {{ __('auth_form.forgot_password_description') }}
            </p>
        </div>

        <flux:card class="space-y-6">
            @if(session('status'))
                <div class="rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-200" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="post" class="space-y-5">
                @csrf

                <flux:input
                    type="email"
                    name="email"
                    :value="old('email')"
                    :label="__('auth_form.email')"
                    autocomplete="email"
                    required
                    autofocus
                />

                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('auth_form.send_reset_link') }}
                </flux:button>
            </form>

            <div class="text-center">
                <flux:link :href="route('login')">
                    {{ __('auth_form.back_to_login') }}
                </flux:link>
            </div>
        </flux:card>
    </div>
</main>
@livewireScripts
@fluxScripts
</body>
</html>
