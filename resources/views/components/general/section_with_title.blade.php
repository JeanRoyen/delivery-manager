@props([
    'title'
])

<section class="space-y-6">
    <h2 class="text-3xl font-bold flex justify-center">{{ $title }}</h2>
    {{ $slot }}
</section>
