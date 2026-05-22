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
};
?>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

    <x-dashboard.card
        :title="__('dashboard.pending_orders')"
        :value="$this->stats['pending']"
    />

    <x-dashboard.card
        :title="__('dashboard.preparing_orders')"
        :value="$this->stats['preparing']"
    />

    <x-dashboard.card
        :title="__('dashboard.delivering_orders')"
        :value="$this->stats['delivering']"
    />

    <x-dashboard.card
        :title="__('dashboard.delivered_orders')"
        :value="$this->stats['delivered']"
    />

</div>
