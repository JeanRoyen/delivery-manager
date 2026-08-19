<?php

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Livewire\Component;

new class extends Component
{
    public Customer $customer;

    public CustomerForm $form;

    public function mount(): void
    {
        $this->form->setCustomer($this->customer);
    }

    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | '.$this->customer->name);
    }

    public function save(): void
    {
        $this->form->update($this->customer);
        $this->customer->refresh();

        Flux::toast(__('toast.changes'));
    }
};
?>

<x-general.section_with_title
    :title="__('form.customer_edit_title', ['customer' => $customer->name])"
>
    <form wire:submit="save">
        <flux:card
            class="overflow-hidden p-0"
            itemscope
            itemtype="https://schema.org/Person"
        >
            <meta itemprop="identifier" content="{{ $customer->id }}">
            <meta itemprop="name" content="{{ $customer->name }}">
            <meta itemprop="email" content="{{ $customer->email }}">
            <meta itemprop="address" content="{{ $customer->address }}">

            @if($customer->phone)
                <meta itemprop="telephone" content="{{ $customer->phone }}">
            @endif

            <div class="space-y-6 p-6 md:p-8">
                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <div class="space-y-1">
                        <flux:heading size="lg">{{ __('form.customer_information') }}</flux:heading>
                        <flux:text>{{ __('form.customer_edit_description') }}</flux:text>
                    </div>

                    <flux:badge color="zinc">#{{ $customer->id }}</flux:badge>
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
                <flux:button variant="primary" color="green" type="submit" icon="check">
                    {{ __('form.update_customer') }}
                </flux:button>
            </div>
        </flux:card>
    </form>
</x-general.section_with_title>
