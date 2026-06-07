<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\States\Order\Failed;

new class extends Component {
    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | ' . __('pages_title.orders_failed'));
    }
};
?>

<x-general.section_with_title title="{{ __('order.failed_title') }}">
    <livewire:order.table :state="Failed::class"/>
</x-general.section_with_title>
