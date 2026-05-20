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
            {{ __('sidebar.dashboard') }}
        </flux:sidebar.item>

        <flux:sidebar.item icon="user" href="{{ route('customer.index') }}">
            {{ __('sidebar.customers') }}
        </flux:sidebar.item>

        <flux:sidebar.item icon="user" href="{{ route('product.index') }}">
            {{ __('sidebar.products') }}
        </flux:sidebar.item>

        <flux:sidebar.group expandable icon="cube" heading="{{ __('sidebar.order_management') }}" class="grid">
            <flux:sidebar.item href="{{ route('pending.index') }}">
                {{ __('sidebar.orders') }}
            </flux:sidebar.item>
            <flux:sidebar.item href="{{ route('preparing.index') }}">
                {{ __('sidebar.preparation') }}
            </flux:sidebar.item>
            <flux:sidebar.item href="{{ route('delivering.index') }}">
                {{ __('sidebar.deliveries') }}
            </flux:sidebar.item>
            <flux:sidebar.item href="{{ route('delivered.index') }}">
                {{ __('sidebar.history') }}
            </flux:sidebar.item>
        </flux:sidebar.group>
    </flux:sidebar.nav>

    <flux:sidebar.spacer />

    <flux:dropdown>
        <flux:button icon:trailing="chevron-down" class="w-full">
            {{ language()->getName() }}
        </flux:button>
        <flux:navmenu>
            @foreach (language()->allowed() as $code => $name)
                <flux:navmenu.item href="{{ language()->back($code) }}">{{ $name }}</flux:navmenu.item>
            @endforeach
        </flux:navmenu>
    </flux:dropdown>

    <flux:switch x-data x-model="$flux.dark" label="{{ __('sidebar.dark_mode') }}" />


    <flux:profile :chevron="false" :name="Str::title(auth()->user()->first_name . ' ' . auth()->user()->last_name)" />


    <form action="{{ route('logout') }}" method="post">
        @csrf
        <flux:button type="submit" class="w-full" variant="danger" icon="arrow-right-start-on-rectangle">
            {{ __('sidebar.logout') }}
        </flux:button>
    </form>

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
