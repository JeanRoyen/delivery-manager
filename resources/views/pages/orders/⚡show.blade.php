<?php

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public Order $order;

    public function render(): View
    {
        return $this->view()->title('Delivery Manager | '.$this->order->code);
    }

    #[Computed]
    public function items()
    {
        return $this->order
            ->items()
            ->with('product')
            ->get();

    }

    #[Computed]
    public function histories()
    {
        return $this->order
            ->histories()
            ->with('user')
            ->latest()
            ->get();
    }

    public function updateState($stateClass, $redirect): void
    {
        $this->order->state->transitionTo($stateClass);

        $this->order->refresh();

        $this->redirect(route($redirect));

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
                <div class="flex items-center gap-3">
                    <flux:text>{{ __('order_show.order.delivery_status') }} :</flux:text>
                    <flux:badge size="lg" color="{{ $order->state->color() }}">
                        {{ $order->state->label() }}
                    </flux:badge>
                </div>

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

                <flux:table.rows>

                    @foreach($this->items as $item)
                        <flux:table.row>

                            <flux:table.cell>
                                {{ $item->product->id }}
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $item->product->name }}
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $item->quantity }}
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ Number::currency($item->unit_price, 'EUR') }}
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ Number::currency($item->total_price, 'EUR') }}
                            </flux:table.cell>

                        </flux:table.row>
                    @endforeach

                </flux:table.rows>

            </flux:table>

            <flux:separator />

            <div class="space-y-4">
                <flux:heading size="lg">
                    {{ __('order_show.history.title') }}
                </flux:heading>

                <div class="space-y-3">
                    @forelse($this->histories as $history)
                        <div class="flex gap-4 rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800/50">
                            <div class="mt-2 size-2 shrink-0 rounded-full bg-indigo-500"></div>

                            <div class="flex-1 space-y-1">
                                <div class="font-medium">
                                    {{ __('order_status.' . $history->from_state) }}
                                    <span class="mx-2 text-zinc-400">→</span>
                                    {{ __('order_status.' . $history->to_state) }}
                                </div>

                                <flux:text size="sm">
                                    @if($history->user)
                                        {{ __('order_show.history.changed_by', [
                                            'user' => ucfirst($history->user->first_name) . ' ' . ucfirst($history->user->last_name),
                                        ]) }}
                                        ·
                                    @endif
                                    {{ $history->created_at->format('d/m/Y H:i') }}
                                </flux:text>
                            </div>
                        </div>
                    @empty
                        <flux:text>{{ __('order_show.history.empty') }}</flux:text>
                    @endforelse
                </div>
            </div>

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
                <div class="flex gap-4">
                    <x-order.failed_button :order="$order" />
                    <x-order.state_button :order="$order" />
                </div>
            </div>
        </div>
    </flux:card>

</x-general.section_with_title>
