@props([
    "orders",
])

<flux:table>
    <flux:table.columns>

        <flux:table.column>ID</flux:table.column>
        <flux:table.column>{{ __('order.customer') }}</flux:table.column>
        <flux:table.column>{{ __('order.created_at') }}</flux:table.column>
        <flux:table.column>{{ __('order.status') }}</flux:table.column>
        <flux:table.column>{{ __('order.total') }}</flux:table.column>

    </flux:table.columns>

    <flux:table.rows>
        @foreach($orders as $order)
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
<flux:pagination :paginator="$orders" />
