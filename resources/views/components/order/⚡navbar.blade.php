<?php

use App\Models\Order;
use App\States\Order\Failed;
use App\States\Order\Pending;
use App\States\Order\Preparing;
use App\States\Order\Delivering;
use App\States\Order\Delivered;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

    #[Computed]
    public function statuses(): Collection
    {
        $states = [
            Pending::class,
            Preparing::class,
            Delivering::class,
            Delivered::class,
            Failed::class,
        ];

        $counts = Order::query()
            ->toBase()
            ->selectRaw('state, COUNT(*) as count')
            ->groupBy('state')
            ->pluck('count', 'state');

        return collect($states)->map(fn($stateClass) => (object)[
            'key' => $stateClass::$name,
            'count' => $counts[$stateClass::$name] ?? 0,
            'color' => $stateClass::$color,
            'label' => __('order_status.' . $stateClass::$name),
            'route' => route($stateClass::$name . '.index'),
        ]);
    }
};
?>

<flux:navbar>
    @foreach($this->statuses as $status)
        <x-order.navbar_item
            :status="$status->key"
            :color="$status->color"
            :count="$status->count"
            :route="$status->route"
            :label="$status->label"
        />
    @endforeach
</flux:navbar>
