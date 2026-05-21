<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function stats(): array
    {
        return [
            'pending' => Order::where('status', OrderStatus::PENDING)->count(),
            'preparing' => Order::where('status', OrderStatus::PREPARING)->count(),
            'delivering' => Order::where('status', OrderStatus::DELIVERING)->count(),
            'delivered' => Order::where('status', OrderStatus::DELIVERED)->count(),
        ];
    }
}
?>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

    <flux:card class="h-full">
        <flux:heading>
            {{ __('dashboard.pending_orders') }}
        </flux:heading>

        <flux:text>
            {{ $this->stats['pending'] }}
        </flux:text>
    </flux:card>

    <flux:card class="h-full">
        <flux:heading>
            {{ __('dashboard.preparing_orders') }}
        </flux:heading>

        <flux:text>
            {{ $this->stats['preparing'] }}
        </flux:text>
    </flux:card>

    <flux:card class="h-full">
        <flux:heading>
            {{ __('dashboard.delivering_orders') }}
        </flux:heading>

        <flux:text>
            {{ $this->stats['delivering'] }}
        </flux:text>
    </flux:card>

    <flux:card class="h-full">
        <flux:heading>
            {{ __('dashboard.delivered_orders') }}
        </flux:heading>

        <flux:text>
            {{ $this->stats['delivered'] }}
        </flux:text>
    </flux:card>

</div>
