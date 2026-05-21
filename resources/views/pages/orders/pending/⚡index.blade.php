<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    use Livewire\WithPagination;

    use Livewire\WithPagination;
    #[Computed]
    public function pendingOrders(): LengthAwarePaginator
    {
        return Order::where('status', OrderStatus::PENDING)
            ->paginate(10);
    }
};
?>

<x-general.section_with_title title="{{ __('order.pending_title') }}">
    <x-order.table :orders="$this->pendingOrders" />
</x-general.section_with_title>
