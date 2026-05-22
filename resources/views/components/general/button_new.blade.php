@props([
    'href',
])

<flux:button
    variant="primary"
    color="green"
    icon="plus"
    :href="$href"
    wire:navigate
>
    {{ $slot }}
</flux:button>
