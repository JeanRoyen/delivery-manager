<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Status;

new class extends Component {
    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | ' . __('pages_title.orders_delivering'));
    }
};
?>

<x-general.section_with_title title="{{ __('order.delivering_title') }}">
    <livewire:order.table :statusId="Status::DELIVERING"/>
</x-general.section_with_title>
