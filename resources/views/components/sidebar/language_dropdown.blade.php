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
