@props([
    'type',
    'name',
    'label',
    'isRequired' => false,
    'value' => '',
])

<div>
    <label for="{{ $name }}">
        {{ $label }}<sup>*</sup>
    </label>

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @required($isRequired)
    >

    @error($name)
    <p>{{ $message }}</p>
    @enderror
</div>
