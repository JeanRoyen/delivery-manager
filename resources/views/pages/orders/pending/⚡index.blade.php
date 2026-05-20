<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

    #[Computed]
    public function pendingOrders(): LengthAwarePaginator
    {
        return Order::where('status', OrderStatus::PENDING)
            ->paginate(10);
    }
};
?>

<div>
</div>
