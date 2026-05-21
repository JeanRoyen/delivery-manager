<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    use Livewire\WithPagination;

    #[Computed]
    public function deliveringOrders(): LengthAwarePaginator
    {
        return Order::where('status', OrderStatus::DELIVERING)
            ->paginate(10);
    }
};
?>

<x-general.section_with_title title="{{ __('order.delivering_title') }}">
    <x-order.table :orders="$this->deliveringOrders" />
</x-general.section_with_title>
