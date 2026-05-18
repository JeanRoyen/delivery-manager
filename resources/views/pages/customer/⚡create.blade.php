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
     <x-general.section_with_title title="{{ __('form.customer_create_title') }}">
         <form wire:submit.prevent="save" class="space-y-4">
             <flux:input type="text" wire:model="form.name" label="{{ __('form.name') }}*" />
             <flux:input type="email" wire:model="form.email" label="{{ __('form.email') }}*" />
             <flux:input type="text" wire:model="form.address" label="{{ __('form.address') }}*" />
             <flux:input type="phone" wire:model="form.phone" label="{{ __('form.phone') }}" />

             <flux:button variant="primary" color="green" type="submit" icon="plus" class="w-full mt-10 py-6">
                 {{ __('form.submit_customer') }}
             </flux:button>
         </form>
     </x-general.section_with_title>
</div>
