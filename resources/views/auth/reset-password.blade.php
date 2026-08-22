<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Delivery Manager | {{ __('pages_title.reset_password') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon-delivery-manager.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
<main class="flex min-h-screen items-center justify-center px-6 py-12" aria-labelledby="reset-password-title">
    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <img src="{{ asset('favicon-delivery-manager.png') }}" alt="" class="mx-auto mb-4 size-16 object-contain">
            <h1 id="reset-password-title" class="text-2xl font-bold text-zinc-900 dark:text-white">
                {{ __('auth_form.reset_password_title') }}
            </h1>
            <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                {{ __('auth_form.reset_password_description') }}
            </p>
        </div>

        <flux:card>
            <form action="{{ route('password.update') }}" method="post" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <flux:input
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    :label="__('auth_form.email')"
                    autocomplete="email"
                    required
                />

                <flux:input
                    type="password"
                    name="password"
                    :label="__('auth_form.new_password')"
                    autocomplete="new-password"
                    required
                />

                <flux:input
                    type="password"
                    name="password_confirmation"
                    :label="__('auth_form.password_confirmation')"
                    autocomplete="new-password"
                    required
                />

                <flux:button variant="primary" type="submit" class="w-full">
                    {{ __('auth_form.reset_password') }}
                </flux:button>
            </form>
        </flux:card>
    </div>
</main>
@livewireScripts
@fluxScripts
</body>
</html>
