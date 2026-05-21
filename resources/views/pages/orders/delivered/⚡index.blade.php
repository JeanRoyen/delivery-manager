<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    use Livewire\WithPagination;

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
    <x-order.table :orders="$this->deliveredOrders" />
</x-general.section_with_title>
