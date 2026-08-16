@props([
    'name',
    'label',
    'type' => 'text',
])

<flux:field>

    <flux:label badge="{{ ucfirst(__('form.abbr_required')) }}">
        {{ $label }}
    </flux:label>

    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        <flux:input
            :type="$type"
            {{ $attributes }}
            required
        />
    @endif

    <flux:error :name="$name" />

</flux:field>
