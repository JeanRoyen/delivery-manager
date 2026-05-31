<?php

use App\States\Order\Delivered;
use App\States\Order\Delivering;
use App\States\Order\OrderState;
use App\States\Order\Pending;
use App\States\Order\Preparing;
use App\Models\Order;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

    #[Computed]
    public function statuses(): Collection
    {
        $states = [
            'pending' => Pending::class,
            'preparing' => Preparing::class,
            'delivering' => Delivering::class,
            'delivered' => Delivered::class,
        ];

        $counts = Order::query()
            ->toBase()
            ->selectRaw('state, COUNT(*) as count')
            ->groupBy('state')
            ->pluck('count', 'state');

        return collect($states)->map(function ($class, $label) use ($counts) {
            return (object) [
                'label' => $label,
                'count' => $counts[$label] ?? 0,
                'color' => match ($label) {
                    'pending' => 'yellow',
                    'preparing' => 'blue',
                    'delivering' => 'purple',
                    'delivered' => 'green',
                },
                'route' => route($label . '.index'),
                'title' => __('order.' . $label . '_title'),
            ];
        });
    }
};
?>

<flux:navbar>
    @foreach($this->statuses as $status)
        <x-order.navbar_item
            :status="$status->label"
            :color="$status->color"
            :count="$status->count"
            :route="$status->route"
            :label="$status->title"
        />
    @endforeach
</flux:navbar>
