<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @fluxAppearance

</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">

<flux:sidebar
    sticky
    collapsible="mobile"
    class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700"
>
    <x-sidebar.nav_menu />

    <flux:sidebar.spacer />

   <livewire:sidebar.avatar_dropdown/>

    <flux:switch x-data x-model="$flux.dark" label="{{ __('sidebar.dark_mode') }}" />

    <x-sidebar.language_dropdown/>


</flux:sidebar>

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
