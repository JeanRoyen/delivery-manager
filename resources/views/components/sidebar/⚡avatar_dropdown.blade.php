<?php

use Livewire\Component;

new class extends Component
{
    public function logout(): void
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login'), navigate: true);
    }
};
?>

<flux:dropdown>

    <flux:profile :name="Str::title(auth()->user()->first_name . ' ' . auth()->user()->last_name)" />

        <flux:navmenu>
            <flux:navmenu.item
                icon="arrow-right-start-on-rectangle"
                wire:click="logout"
            >
                {{ __('sidebar.logout') }}
            </flux:navmenu.item>
        </flux:navmenu>
</flux:dropdown>
