<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use App\States\Order\Delivered;
use App\States\Order\Delivering;
use App\States\Order\Pending;
use App\States\Order\Preparing;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public Order $order;

    public function render(): View
    {
        return $this->view()->title('Delivery Manager | ' . $this->order->code);
    }

    public function updateState($stateClass, $redirect): void
    {
        $this->order->state->transitionTo($stateClass);

        $this->order->refresh();

        $this->redirect(route($redirect));
    }

    #[Computed]
    public function products(): Collection
    {
        return Product::all();
    }
};
?>


<x-general.section_with_title
    :title="__('order_show.order.details_title', [
        'customer' => $order->customer->name,
    ])"
>
    <flux:card class="space-y-6">
        <div class="max-w-7xl mx-auto space-y-8">

            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="xl">
                        #{{ $order->code }}
                    </flux:heading>

                    <flux:text>
                        {{ __('order_show.order.see_command') }}
                    </flux:text>
                </div>

                <flux:badge size="lg" color="{{ $order->state->color() }}">
                    {{ $order->state->label() }}
                </flux:badge>
            </div>
            <flux:heading size="lg">
                {{ __('order_show.customer.informations') }}
            </flux:heading>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

                <flux:card size="sm">
                    <flux:text>{{ __('order_show.customer.name') }}</flux:text>

                    <div class="font-semibold">
                        {{ $order->customer->name }}
                    </div>
                </flux:card>

                <flux:card size="sm">
                    <flux:text>{{ __('order_show.customer.email') }}</flux:text>

                    <div class="font-semibold">
                        {{ $order->customer->email }}
                    </div>
                </flux:card>

                <flux:card size="sm">
                    <flux:text>{{ __('order_show.customer.phone') }}</flux:text>

                    <div class="font-semibold">
                        {{ $order->customer->phone }}
                    </div>
                </flux:card>

                <flux:card size="sm">
                    <flux:text>{{ __('order_show.customer.address') }}</flux:text>

                    <div class="font-semibold">
                        {{ $order->customer->address }}
                    </div>
                </flux:card>

            </div>

            <flux:separator />

            <div class="flex items-center justify-between">

                <flux:heading size="lg">
                    {{ __('order_show.order.products') }}
                </flux:heading>

            </div>

            <flux:table>

                <flux:table.columns>
                    <flux:table.column>{{ __('order_show.product.reference') }}</flux:table.column>
                    <flux:table.column>{{ __('order_show.product.name') }}</flux:table.column>
                    <flux:table.column>{{ __('order_show.product.quantity') }}</flux:table.column>
                    <flux:table.column>{{ __('order_show.product.price') }}</flux:table.column>
                    <flux:table.column>{{ __('order_show.general.actions') }}</flux:table.column>
                </flux:table.columns>

            </flux:table>

            <flux:separator />

            <div class="flex justify-between items-center">

                <div class="space-y-1">
                    <flux:text>
                        {{ __('order_show.order.total_amount') }}
                    </flux:text>

                    <div class="text-xl font-bold">
                        {{ Number::currency($order->total_amount, 'EUR') }}
                    </div>
                </div>

                <x-order.state_button :order="$order"/>

            </div>
        </div>
    </flux:card>

</x-general.section_with_title>

