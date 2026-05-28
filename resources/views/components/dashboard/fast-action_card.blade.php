@props([
    'title',
    'button',
    'href',
])

<flux:card class="flex items-center gap-5 p-6">
    <div class="shrink-0">
        {{ $icon }}
    </div>

    <div class="space-y-3">
        <flux:heading size="lg">
            {{ $title }}
        </flux:heading>

        <flux:button
            variant="primary"
            color="green"
            wire:navigate
            href="{{ $href }}"
        >
            {{ $button }}
        </flux:button>
    </div>
</flux:card>
