@props([
    'name',
    'label',
    'type' => 'text',
])

<flux:field>

    <flux:label badge="{{ ucfirst(__('form.abbr_required')) }}">
        {{ $label }}
    </flux:label>

    <flux:input
        :type="$type"
        {{ $attributes }}
        required
    />

    <flux:error :name="$name" />

</flux:field>
