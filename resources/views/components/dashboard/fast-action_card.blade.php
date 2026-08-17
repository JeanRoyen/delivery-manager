@props([
    'title',
    'button',
    'href',
    'iconClass' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200',
    'buttonColor' => 'green',
])

<flux:card class="group flex h-full flex-col p-6 transition duration-200 hover:-translate-y-1 hover:border-zinc-300 hover:shadow-lg dark:hover:border-zinc-600">
    <div class="mb-6">
        <div class="inline-flex rounded-2xl p-3 transition duration-200 group-hover:scale-105 {{ $iconClass }}">
            {{ $icon }}
        </div>
    </div>

    <div class="flex flex-1 flex-col items-start gap-5">
        <flux:heading size="lg" class="text-balance">
            {{ $title }}
        </flux:heading>

        <flux:button
            class="mt-auto w-full justify-center py-2.5"
            variant="primary"
            :color="$buttonColor"
            wire:navigate
            href="{{ $href }}"
        >
            {{ $button }}
        </flux:button>
    </div>
</flux:card>
