<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

    #[Computed]
    public function preparingOrders(): LengthAwarePaginator
    {
        return Order::where('status', OrderStatus::PREPARING)
            ->paginate(10);
    }
};
?>

<div>
</div>
