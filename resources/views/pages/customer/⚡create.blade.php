<?php

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public CustomerForm $form;

    public function render()
    {
        return $this->view()->title('Delivery Manager | ' . __('pages_title.customer_create'));
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('customer.index'));
    }
}
?>

<div>
    <x-general.section_with_title title="{{ __('form.customer_create_title') }}">
        <form wire:submit="save" class="space-y-4">
            <x-form.input_required
                name="form.name"
                :label="__('form.name')"
                wire:model="form.name"
            />

            <x-form.input_required
                name="form.email"
                :label="__('form.email')"
                type="email"
                wire:model="form.email"
            />

            <x-form.input_required
                name="form.address"
                :label="__('form.address')"
                wire:model="form.address"
            />

            <flux:input type="phone" wire:model="form.phone" label="{{ __('form.phone') }}" />

            <flux:button variant="primary" color="green" type="submit" icon="plus" class="w-full mt-10 py-6">
                {{ __('form.submit_customer') }}
            </flux:button>
        </form>
    </x-general.section_with_title>
</div>
