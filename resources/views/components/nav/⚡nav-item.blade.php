<?php

use Livewire\Component;

new class extends Component {
    public string $name;
    public string $route;
};
?>

<a href="{{ $route }}" wire:navigate wire:current="font-bold">{{ $name }}</a>
