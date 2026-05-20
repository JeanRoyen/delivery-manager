<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

    #[Computed]
    public function deliveredOrders(): LengthAwarePaginator
    {
        return Order::query()
            ->with(['customer', 'items'])
            ->where('status', OrderStatus::DELIVERED)
            ->latest()
            ->paginate(10);
    }
};
?>

<x-general.section_with_title title="{{ __('order.delivered_title') }}">
    <flux:table>
        <flux:table.columns>

            <flux:table.column>ID</flux:table.column>
            <flux:table.column>{{ __('order.customer') }}</flux:table.column>
            <flux:table.column>{{ __('order.created_at') }}</flux:table.column>
            <flux:table.column>{{ __('order.status') }}</flux:table.column>
            <flux:table.column>{{ __('order.total') }}</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->deliveredOrders as $order)
                <flux:table.row>

                    <flux:table.cell>
                        {{ $order->id }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $order->customer->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $order->status->label() }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ money($order->total_amount, 'EUR') }}
                    </flux:table.cell>

                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</x-general.section_with_title>
