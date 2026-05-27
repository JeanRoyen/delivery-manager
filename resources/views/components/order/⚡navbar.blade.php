<?php

use App\Models\Status;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    #[Computed]
    public function statuses(): Collection
    {
        return Status::query()
            ->withCount('orders')
            ->get();
    }
};
?>

<flux:navbar class="flex justify-center">

    @foreach($this->statuses as $status)
        <x-order.navbar_item
            :status="$status->label"
            :color="$status->color"
            :count="$status->orders_count"
            :route="route($status->label . '.index')"
            :label="__('sidebar.' . match ($status->label) {
                'pending' => 'orders',
                'preparing' => 'preparation',
                'delivering' => 'deliveries',
                'delivered' => 'history',
            })"
        />
    @endforeach

</flux:navbar>
