@props([
    'title',
    'value',
])

<flux:card class="h-full">
    <flux:heading>
        {{ $title }}
    </flux:heading>

    <flux:text>
        {{ $value }}
    </flux:text>
</flux:card>
