<?php

use Akaunting\Money\Money;
use App\Livewire\Forms\ProductForm;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public ProductForm $form;

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('product.index'));
    }
}
?>

<div>
    <x-general.section_with_title title="{{ __('form.product_create_title') }}">
        <form wire:submit.prevent="save" class="space-y-4">
            <x-form.input_required
                name="form.name"
                :label="__('form.name')"
                wire:model="form.name"
            />
            <x-form.input_required
                name="form.price"
                :label="__('form.price')"
                wire:model="form.price"
            />
            <flux:input type="text" wire:model="form.description" label="{{ __('form.description') }}" />

            <flux:button variant="primary" color="green" type="submit" icon="plus" class="w-full mt-6 py-6">
                {{ __('form.submit_product') }}
            </flux:button>
        </form>
    </x-general.section_with_title>
</div>
