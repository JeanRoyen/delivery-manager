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
        return Order::where('status', OrderStatus::DELIVERED)
            ->paginate(10);
    }
};
?>

<div>
</div>
