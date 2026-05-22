<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public OrderStatus $status;

    #[Computed]
    public function orders(): LengthAwarePaginator
    {
        return Order::query()
            ->with(['customer', 'items'])
            ->where('status', $this->status)
            ->latest()
            ->paginate(10);
    }
};
?>
<div>
    <flux:table>
        <flux:table.columns>

            <flux:table.column>ID</flux:table.column>
            <flux:table.column>{{ __('order.customer') }}</flux:table.column>
            <flux:table.column>{{ __('order.created_at') }}</flux:table.column>
            <flux:table.column>{{ __('order.status') }}</flux:table.column>
            <flux:table.column>{{ __('order.total') }}</flux:table.column>

        </flux:table.columns>

        <flux:table.rows>
            @foreach($this->orders as $order)
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
                        <flux:badge color="{{ $order->status->badgeColor() }}">
                            {{ $order->status->label() }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ money($order->total_amount, 'EUR') }}
                    </flux:table.cell>

                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
    <flux:pagination :paginator="$this->orders" />
</div>

