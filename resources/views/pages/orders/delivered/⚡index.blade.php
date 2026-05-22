<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

};
?>

<x-general.section_with_title title="{{ __('order.delivered_title') }}">
    <livewire:order.table :status="OrderStatus::DELIVERED"/>
</x-general.section_with_title>
