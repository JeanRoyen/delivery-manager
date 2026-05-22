<flux:sidebar.header>
    <flux:sidebar.brand
        href="{{ route('dashboard.index') }}"
        name="Delivery Manager"
    />

    <flux:sidebar.collapse class="lg:hidden" />
</flux:sidebar.header>

<flux:sidebar.nav>
    <flux:sidebar.item icon="squares-2x2" href="{{ route('dashboard.index') }}">
        {{ __('sidebar.dashboard') }}
    </flux:sidebar.item>

    <flux:sidebar.item icon="user" href="{{ route('customer.index') }}">
        {{ __('sidebar.customers') }}
    </flux:sidebar.item>

    <flux:sidebar.item icon="list-bullet" href="{{ route('product.index') }}">
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
