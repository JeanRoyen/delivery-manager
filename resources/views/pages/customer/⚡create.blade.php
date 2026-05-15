<?php

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public CustomerForm $form;

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('customer.index'));
    }
}
?>

<div>
    <section>
        <h2 class="flex justify-center text-3xl mb-6">Création d'un nouveau client</h2>
        <form wire:submit.prevent="save">
            <flux:input type="text" wire:model="form.name" label="Nom*" />
            <flux:input type="email" wire:model="form.email" label="Email*" />
            <flux:input type="text" wire:model="form.address" label="Adresse*" />
            <flux:input type="phone" wire:model="form.phone" label="N° de téléphone" />

            <flux:button variant="primary" color="green" type="submit" icon="plus" class="w-full mt-10 py-6">
                Enregister le nouveau client
            </flux:button>
        </form>
    </section>
</div>
