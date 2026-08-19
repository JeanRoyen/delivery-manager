<?php

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use Livewire\Component;

new class extends Component
{
    public Product $product;

    public ProductForm $form;

    public function mount(): void
    {
        $this->form->setProduct($this->product);
    }

    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | '.$this->product->name);
    }

    public function save(): void
    {
        $this->form->update($this->product);
        $this->product->refresh();

        Flux::toast(__('toast.changes'));
    }
};
?>

<x-general.section_with_title
    :title="__('form.product_edit_title', ['product' => $product->name])"
>
    <form wire:submit="save">
        <flux:card
            class="overflow-hidden p-0"
            itemscope
            itemtype="https://schema.org/Product"
        >
            <meta itemprop="sku" content="{{ $product->id }}">
            <meta itemprop="name" content="{{ $product->name }}">

            @if($product->description)
                <meta itemprop="description" content="{{ $product->description }}">
            @endif

            <span itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <meta itemprop="price" content="{{ number_format($product->price / 100, 2, '.', '') }}">
                <meta itemprop="priceCurrency" content="EUR">
            </span>

            <div class="space-y-6 p-6 md:p-8">
                <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                    <div class="space-y-1">
                        <flux:heading size="lg">{{ __('form.product_information') }}</flux:heading>
                        <flux:text>{{ __('form.product_edit_description') }}</flux:text>
                    </div>

                    <flux:badge color="zinc">#{{ $product->id }}</flux:badge>
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
                <flux:button variant="primary" color="green" type="submit" icon="check">
                    {{ __('form.update_product') }}
                </flux:button>
            </div>
        </flux:card>
    </form>
</x-general.section_with_title>
