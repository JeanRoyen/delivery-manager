<?php

use App\Livewire\Forms\ProductForm;
use Livewire\Component;

new class extends Component
{
    public ProductForm $form;

    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | '.__('pages_title.product_create'));
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('product.index'));
    }
}
?>

<div>
    <x-general.section_with_title title="{{ __('form.product_create_title') }}">
        <form wire:submit="save">
            <flux:card class="overflow-hidden p-0">
                <div class="space-y-6 p-6 md:p-8">
                    <div class="space-y-1">
                        <flux:heading size="lg">{{ __('form.product_information') }}</flux:heading>
                        <flux:text>{{ __('form.product_information_description') }}</flux:text>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
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

                        <div class="md:col-span-2">
                            <flux:textarea
                                wire:model="form.description"
                                :label="__('form.description')"
                            />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end border-t border-zinc-200 bg-zinc-50 px-6 py-5 md:px-8 dark:border-zinc-700 dark:bg-zinc-800/50">
                    <flux:button variant="primary" color="green" type="submit" icon="plus">
                        {{ __('form.submit_product') }}
                    </flux:button>
                </div>
            </flux:card>
        </form>
    </x-general.section_with_title>
</div>
