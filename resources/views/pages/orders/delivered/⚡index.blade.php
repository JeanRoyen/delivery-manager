<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\States\Order\Delivered;

new class extends Component {

    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | ' . __('pages_title.orders_delivered'));
    }

};
?>

<x-general.section_with_title title="{{ __('order.delivered_title') }}">
    <livewire:order.table :state="Delivered::class"/>
</x-general.section_with_title>
