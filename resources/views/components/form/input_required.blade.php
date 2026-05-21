@props([
    'name',
    'label',
    'type' => 'text',
])

<flux:field>

    <flux:label>
        {{ $label }}
        <x-general.abbr_required_star />
    </flux:label>

    <flux:input
        :type="$type"
        {{ $attributes }}
    />

    <flux:error :name="$name" />

</flux:field>
