<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">

<x-sidebar.sidebar/>

<flux:main>
    @persist('toast')
    <flux:toast position="top end" />
    @endpersist
    {{ $slot }}
</flux:main>
<footer>

</footer>
@livewireScripts
@fluxScripts
</body>
</html>
