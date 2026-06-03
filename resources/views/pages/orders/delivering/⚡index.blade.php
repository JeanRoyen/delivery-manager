<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\States\Order\Delivering;

new class extends Component {
    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | ' . __('pages_title.orders_delivering'));
    }
};
?>

<x-general.section_with_title title="{{ __('order.delivering_title') }}">
    <livewire:order.table :state="Delivering::class"/>
</x-general.section_with_title>
