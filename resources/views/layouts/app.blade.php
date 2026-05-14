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
    <flux:sidebar.header>
        <flux:sidebar.brand
            href="{{ route('dashboard.index') }}"
            name="Delivery Manager"
        />

        <flux:sidebar.collapse class="lg:hidden" />
    </flux:sidebar.header>

    <flux:sidebar.nav>
        <flux:sidebar.item icon="home" href="{{ route('dashboard.index') }}">
            Dashboard
        </flux:sidebar.item>

        <flux:sidebar.item icon="user" href="{{ route('customer.index') }}">
            Clients
        </flux:sidebar.item>

        <flux:sidebar.item icon="cake" href="{{ route('order.index') }}">
            Commandes
        </flux:sidebar.item>

        <flux:sidebar.item icon="cake" href="{{ route('preparation.index') }}">
            Préparation
        </flux:sidebar.item>

        <flux:sidebar.item icon="cake" href="{{ route('delivery.index') }}">
            Livraisons
        </flux:sidebar.item>

        <flux:sidebar.item icon="cake" href="{{ route('historic.index') }}">
            Historique
        </flux:sidebar.item>
    </flux:sidebar.nav>

    <flux:sidebar.spacer />

    <flux:switch x-data x-model="$flux.dark" label="Dark mode" />

    <flux:profile :name="Str::title(auth()->user()->first_name . ' ' . auth()->user()->last_name)"
                  :chevron="false"/>
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <flux:button type="submit" class="w-full" variant="danger" icon="arrow-right-start-on-rectangle">
            Logout
        </flux:button>
    </form>

</flux:sidebar>

<flux:main>
    {{ $slot }}
</flux:main>
<footer>

</footer>
@livewireScripts
@fluxScripts
</body>
</html>
