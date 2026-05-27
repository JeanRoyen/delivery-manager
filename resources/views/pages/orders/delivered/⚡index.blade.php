<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Status;

new class extends Component {

};
?>

<x-general.section_with_title title="{{ __('order.delivered_title') }}">
    <livewire:order.table :statusId="Status::DELIVERED"/>
</x-general.section_with_title>
