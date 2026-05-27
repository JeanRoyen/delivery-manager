@props([
    'status',
    'color',
    'count',
    'route',
    'label',
])

<flux:navbar.item
    badge="{{ $count }}"
    :badge-color="$color"
    :href="$route"
>
    {{ $label }}
</flux:navbar.item>
