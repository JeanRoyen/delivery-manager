@props([
    'title'
])

<section>
    <h2 class="text-3xl font-bold flex justify-center">{{ $title }}</h2>
    {{ $slot }}
</section>
