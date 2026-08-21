<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Delivery Manager | {{ __('errors.403.page_title') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon-delivery-manager.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-950 dark:text-white">
<main class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-16">
    <div
        class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(16,185,129,0.14),_transparent_45%)]"
        aria-hidden="true"
    ></div>

    <div class="relative w-full max-w-xl text-center">
        <img
            src="{{ asset('favicon-delivery-manager.png') }}"
            alt=""
            class="mx-auto mb-6 size-20 object-contain"
        >

        <p class="text-8xl font-black tracking-tight text-emerald-600 sm:text-9xl" aria-hidden="true">
            403
        </p>

        <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">
            {{ __('errors.403.heading') }}
        </h1>

        <p class="mx-auto mt-4 max-w-md text-base leading-7 text-zinc-600 dark:text-zinc-300">
            {{ __('errors.403.description') }}
        </p>

        <a
            href="{{ route('dashboard.index') }}"
            class="mt-8 inline-flex items-center justify-center rounded-md border border-zinc-300 bg-white px-4 py-2.5 text-sm font-medium text-zinc-800 transition hover:bg-zinc-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-500 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:hover:bg-zinc-800"
        >
            {{ __('errors.403.back_to_dashboard') }}
        </a>
    </div>
</main>
</body>
</html>
