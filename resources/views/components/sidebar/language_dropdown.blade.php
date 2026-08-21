<flux:dropdown>
    <flux:button icon:trailing="chevron-down" class="w-full">
        {{ language()->getName() }}
    </flux:button>
    <flux:navmenu
        aria-label="{{ __('sidebar.language_navigation') }}"
    >
        <h2 class="sr-only">{{ __('sidebar.language_navigation') }}</h2>

        @foreach (language()->allowed() as $code => $name)
            <flux:navmenu.item href="{{ language()->back($code) }}">{{ $name }}</flux:navmenu.item>
        @endforeach
    </flux:navmenu>
</flux:dropdown>
