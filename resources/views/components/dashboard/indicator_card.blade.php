@props([
    'title',
    'value',
    'href',
    'iconClass' => 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-300',
])

<a
    href="{{ $href }}"
    wire:navigate
    class="group block rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
>
    <flux:card class="flex items-center justify-between gap-4 transition group-hover:-translate-y-0.5 group-hover:border-zinc-300 group-hover:shadow-md dark:group-hover:border-zinc-600">
        <div class="space-y-1">
            <flux:text>{{ $title }}</flux:text>
            <div class="text-3xl font-bold">{{ $value }}</div>
        </div>

        <div class="rounded-xl p-3 {{ $iconClass }}">
            {{ $icon }}
        </div>
    </flux:card>
</a>
