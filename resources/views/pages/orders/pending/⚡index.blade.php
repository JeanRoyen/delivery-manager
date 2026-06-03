<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\States\Order\Pending;

new class extends Component {
    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | ' . __('pages_title.orders_pending'));
    }
};
?>

<x-general.section_with_title title="{{ __('order.pending_title') }}">
    <livewire:order.table :state="Pending::class"/>
</x-general.section_with_title>
