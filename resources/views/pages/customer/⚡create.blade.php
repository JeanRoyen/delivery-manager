<?php

use App\Livewire\Forms\CustomerForm;
use Livewire\Component;

new class extends Component
{
    public CustomerForm $form;

    public function render()
    {
        return $this->view()->title('Delivery Manager | '.__('pages_title.customer_create'));
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
        <form wire:submit="save">
            <flux:card class="overflow-hidden p-0">
                <div class="space-y-6 p-6 md:p-8">
                    <div class="space-y-1">
                        <flux:heading size="lg">{{ __('form.customer_information') }}</flux:heading>
                        <flux:text>{{ __('form.customer_information_description') }}</flux:text>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
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

                        <div class="md:col-span-2">
                            <x-form.input_required
                                name="form.address"
                                :label="__('form.address')"
                                wire:model="form.address"
                            />
                        </div>

                        <flux:input
                            type="tel"
                            wire:model="form.phone"
                            :label="__('form.phone')"
                        />
                    </div>
                </div>

                <div class="flex justify-end border-t border-zinc-200 bg-zinc-50 px-6 py-5 md:px-8 dark:border-zinc-700 dark:bg-zinc-800/50">
                    <flux:button variant="primary" color="green" type="submit" icon="plus">
                        {{ __('form.submit_customer') }}
                    </flux:button>
                </div>
            </flux:card>
        </form>
    </x-general.section_with_title>
</div>
