<?php

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public Order $order;

    public bool $showIncidentModal = false;

    public string $incidentMessage = '';

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

    public function openIncidentModal(): void
    {
        $this->resetValidation('incidentMessage');
        $this->incidentMessage = '';
        $this->showIncidentModal = true;
    }

    public function reportIncident(): void
    {
        $this->validate(
            ['incidentMessage' => ['required', 'string', 'max:1000']],
            [],
            ['incidentMessage' => strtolower(__('order_show.incident.message'))]
        );

        $this->order->update([
            'incident_message' => $this->incidentMessage,
        ]);

        $this->order->state->transitionTo('failed');
        $this->order->refresh();
        $this->showIncidentModal = false;
    }
};
?>


<x-general.section_with_title
    :title="__('order_show.order.details_title', [
        'customer' => $order->customer->name,
    ])"
>
    <flux:card
        class="space-y-6"
        itemscope
        itemtype="https://schema.org/Order"
    >
        <meta itemprop="orderNumber" content="{{ $order->code }}">
        <meta itemprop="orderDate" content="{{ $order->created_at->toIso8601String() }}">
        <meta itemprop="orderStatus" content="{{ $order->state->label() }}">

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

            @if($order->incident_message)
                <div class="rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900/60 dark:bg-red-950/30">
                    <div class="flex gap-3">
                        <flux:icon.exclamation-triangle class="mt-0.5 size-5 shrink-0 text-red-600 dark:text-red-400" />

                        <div class="space-y-1">
                            <flux:heading size="sm" class="text-red-800 dark:text-red-300">
                                {{ __('order_show.incident.title') }}
                            </flux:heading>
                            <flux:text class="whitespace-pre-line text-red-700 dark:text-red-300">
                                {{ $order->incident_message }}
                            </flux:text>
                        </div>
                    </div>
                </div>
            @endif

            <flux:heading size="lg">
                {{ __('order_show.customer.informations') }}
            </flux:heading>

            <div
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4"
                itemprop="customer"
                itemscope
                itemtype="https://schema.org/Person"
            >

                <flux:card size="sm">
                    <flux:text>{{ __('order_show.customer.name') }}</flux:text>

                    <div class="font-semibold" itemprop="name">
                        {{ $order->customer->name }}
                    </div>
                </flux:card>

                <flux:card size="sm">
                    <flux:text>{{ __('order_show.customer.email') }}</flux:text>

                    <div class="font-semibold" itemprop="email">
                        {{ $order->customer->email }}
                    </div>
                </flux:card>

                <flux:card size="sm">
                    <flux:text>{{ __('order_show.customer.phone') }}</flux:text>

                    <div class="font-semibold" itemprop="telephone">
                        {{ $order->customer->phone }}
                    </div>
                </flux:card>

                <flux:card size="sm">
                    <flux:text>{{ __('order_show.customer.address') }}</flux:text>

                    <div class="font-semibold" itemprop="address">
                        {{ $order->customer->address }}
                    </div>
                </flux:card>

            </div>

            <div class="flex flex-wrap gap-3">
                <flux:button
                    href="mailto:{{ $order->customer->email }}"
                    icon="envelope"
                    variant="primary"
                    color="sky"
                >
                    {{ __('order_show.customer.send_email') }}
                </flux:button>

                @if($order->customer->phone)
                    <flux:button
                        href="tel:{{ $order->customer->phone }}"
                        icon="phone"
                        variant="primary"
                        color="emerald"
                    >
                        {{ __('order_show.customer.call') }}
                    </flux:button>
                @endif

                <flux:button
                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->customer->address) }}"
                    icon="map-pin"
                    variant="primary"
                    color="violet"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    {{ __('order_show.customer.open_maps') }}
                </flux:button>
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
                        <flux:table.row
                            itemprop="orderedItem"
                            itemscope
                            itemtype="https://schema.org/OrderItem"
                        >

                            <meta itemprop="orderQuantity" content="{{ $item->quantity }}">
                            <meta itemprop="orderItemNumber" content="{{ $item->id }}">

                            <flux:table.cell>
                                <span
                                    itemprop="orderedItem"
                                    itemscope
                                    itemtype="https://schema.org/Product"
                                >
                                    <span itemprop="sku">{{ $item->product->id }}</span>
                                    <meta itemprop="name" content="{{ $item->product->name }}">
                                </span>
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

                    <div
                        class="text-xl font-bold"
                        itemprop="priceSpecification"
                        itemscope
                        itemtype="https://schema.org/PriceSpecification"
                    >
                        <meta itemprop="price" content="{{ number_format($order->total_amount / 100, 2, '.', '') }}">
                        <meta itemprop="priceCurrency" content="EUR">
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

    <flux:modal wire:model="showIncidentModal" class="space-y-6">
        <form wire:submit="reportIncident" class="space-y-6">
            <div class="space-y-2">
                <flux:heading size="lg">{{ __('order_show.incident.modal_title') }}</flux:heading>
                <flux:text>{{ __('order_show.incident.description') }}</flux:text>
            </div>

            <flux:textarea
                wire:model="incidentMessage"
                :label="__('order_show.incident.message')"
                rows="5"
                required
            />

            <div class="flex justify-end gap-3">
                <flux:modal.close>
                    <flux:button type="button" variant="ghost">
                        {{ __('order_show.incident.cancel') }}
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" color="red" icon="exclamation-triangle">
                    {{ __('order_show.incident.confirm') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

</x-general.section_with_title>
