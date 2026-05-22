<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function stats(): array
    {
        $raw = Order::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [];

        foreach (OrderStatus::cases() as $status) {
            $stats[$status->value] = $raw[$status->value] ?? 0;
        }

        return $stats;
    }
};
?>

<flux:navbar class="flex justify-center">
    <x-order.navbar_item
        :status="OrderStatus::PENDING"
        :count="$this->stats['pending']"
        :route="route('pending.index')"
        :label="__('sidebar.orders')"
    />
    <x-order.navbar_item
        :status="OrderStatus::PREPARING"
        :count="$this->stats['preparing']"
        :route="route('preparing.index')"
        :label="__('sidebar.preparation')"
    />

    <x-order.navbar_item
        :status="OrderStatus::DELIVERING"
        :count="$this->stats['delivering']"
        :route="route('delivering.index')"
        :label="__('sidebar.deliveries')"
    />

    <x-order.navbar_item
        :status="OrderStatus::DELIVERED"
        :count="$this->stats['delivered']"
        :route="route('delivered.index')"
        :label="__('sidebar.history')"
    />
</flux:navbar>
