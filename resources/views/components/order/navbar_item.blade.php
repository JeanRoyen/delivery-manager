@props([
    'status',
    'count',
    'route',
    'label',
])

@php
    use App\Enums\OrderStatus;
@endphp

<flux:navbar.item
    badge="{{ $count }}"
    :badge-color="$status->badgeColor()"
    :href="$route"
>
    {{ $label }}
</flux:navbar.item>
