<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Status;

new class extends Component {
    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | ' . __('pages_title.orders_preparing'));
    }
};
?>

<x-general.section_with_title title="{{ __('order.preparing_title') }}">
    <livewire:order.table :statusId="Status::PREPARING"/>
</x-general.section_with_title>
