<?php

use App\Livewire\Forms\OrderForm;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public OrderForm $form;

    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | '.__('pages_title.orders_create'));
    }

    #[Computed]
    public function products(): Collection
    {
        return Product::all();
    }

    #[Computed]
    public function selectedCustomer(): ?Customer
    {
        return Customer::find($this->form->customer_id);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('pending.index'));
    }

    public function addItem(): void
    {
        $this->form->addItem();
    }

    public function removeItem(int $index): void
    {
        $this->form->removeItem($index);
    }

    public function itemSubtotal(array $item): int
    {
        $product = $this->products->firstWhere('id', (int) ($item['product_id'] ?? 0));
        $quantity = max(0, (int) ($item['quantity'] ?? 0));

        return $product ? $product->price * $quantity : 0;
    }
};
?>

<x-general.section_with_title title="{{ __('form.order_create_title') }}">

    <form wire:submit="save">
        <flux:card class="overflow-hidden p-0">
            <div class="space-y-8 p-6 md:p-8">
                <section class="space-y-4">
                    <div class="space-y-1">
                        <flux:heading size="lg">{{ __('form.customer') }}</flux:heading>
                        <flux:text>{{ __('form.select_order_customer') }}</flux:text>
                    </div>

                    <div class="max-w-2xl">
                        <x-form.input_required name="form.customer_id" :label="__('form.customer')">
                            <livewire:form.search_customers
                                wire:model.live="form.customer_id"
                                :key="'order-customer'"
                            />
                        </x-form.input_required>
                    </div>

                    <div class="grid grid-cols-1 gap-4 rounded-xl bg-zinc-50 p-4 sm:grid-cols-2 xl:grid-cols-4 dark:bg-zinc-800/50">
                        <div class="space-y-1">
                            <flux:text size="sm">{{ __('form.name') }}</flux:text>
                            @if($this->selectedCustomer)
                                <div class="font-medium">{{ $this->selectedCustomer->name }}</div>
                            @else
                                <div class="text-zinc-400">—</div>
                            @endif
                        </div>

                        <div class="space-y-1">
                            <flux:text size="sm">{{ __('form.address') }}</flux:text>
                            @if($this->selectedCustomer)
                                <div class="font-medium">{{ $this->selectedCustomer->address }}</div>
                            @else
                                <div class="text-zinc-400">—</div>
                            @endif
                        </div>

                        <div class="space-y-1">
                            <flux:text size="sm">{{ __('form.email') }}</flux:text>
                            @if($this->selectedCustomer)
                                <flux:link href="mailto:{{ $this->selectedCustomer->email }}">
                                    {{ $this->selectedCustomer->email }}
                                </flux:link>
                            @else
                                <div class="text-zinc-400">—</div>
                            @endif
                        </div>

                        <div class="space-y-1">
                            <flux:text size="sm">{{ __('form.phone') }}</flux:text>
                            @if($this->selectedCustomer?->phone)
                                    <flux:link href="tel:{{ $this->selectedCustomer->phone }}">
                                        {{ $this->selectedCustomer->phone }}
                                    </flux:link>
                            @elseif($this->selectedCustomer)
                                <flux:text>{{ __('form.not_provided') }}</flux:text>
                            @else
                                <div class="text-zinc-400">—</div>
                            @endif
                        </div>
                    </div>
                </section>

                <flux:separator />

                <section class="space-y-5">
                    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                        <div class="space-y-1">
                            <flux:heading size="lg">{{ __('form.order_items') }}</flux:heading>
                            <flux:text>{{ __('form.add_order_items_description') }}</flux:text>
                        </div>

                        <flux:button type="button" variant="ghost" icon="plus" wire:click="addItem">
                            {{ __('form.add_item') }}
                        </flux:button>
                    </div>

                    <div class="space-y-3">
                        @foreach($form->items as $index => $item)
                            <div
                                wire:key="order-item-{{ $index }}"
                                class="grid grid-cols-1 items-start gap-4 rounded-xl bg-zinc-50 p-4 md:grid-cols-[minmax(0,1fr)_8rem_10rem_auto] dark:bg-zinc-800/50"
                            >
                                <x-form.input_required
                                    name="form.items.{{ $index }}.product_id"
                                    :label="__('form.product')"
                                >
                                    <flux:select
                                        wire:model.live="form.items.{{ $index }}.product_id"
                                        placeholder="{{ __('form.select_product') }}"
                                    >
                                        @foreach($this->products as $product)
                                            <flux:select.option value="{{ $product->id }}">
                                                #{{ $product->id }} — {{ $product->name }} — {{ money($product->price, 'EUR') }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </x-form.input_required>

                                <x-form.input_required
                                    name="form.items.{{ $index }}.quantity"
                                    :label="__('form.quantity')"
                                    type="number"
                                    min="1"
                                    max="999"
                                    wire:model.live.debounce.250ms="form.items.{{ $index }}.quantity"
                                />

                                <div class="space-y-2 md:pt-1">
                                    <flux:label>{{ __('form.subtotal') }}</flux:label>
                                    <div class="pt-2 font-semibold">
                                        {{ money($this->itemSubtotal($item), 'EUR') }}
                                    </div>
                                </div>

                                <div class="md:pt-7">
                                    <flux:button
                                        type="button"
                                        variant="ghost"
                                        icon="trash"
                                        wire:click="removeItem({{ $index }})"
                                        :disabled="count($form->items) === 1"
                                        :aria-label="__('form.remove_item')"
                                    />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="flex flex-col gap-5 border-t border-zinc-200 bg-zinc-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between md:px-8 dark:border-zinc-700 dark:bg-zinc-800/50">
                <div class="flex items-baseline justify-between gap-8 sm:justify-start">
                    <flux:heading size="lg">{{ __('form.order_total') }}</flux:heading>
                    <div class="text-2xl font-bold" wire:loading.class="opacity-50">
                        {{ money($form->calculateTotal(), 'EUR') }}
                    </div>
                </div>

                <flux:button variant="primary" color="green" type="submit" icon="plus">
                    {{ __('form.submit_order') }}
                </flux:button>
            </div>
        </flux:card>
    </form>
</x-general.section_with_title>
