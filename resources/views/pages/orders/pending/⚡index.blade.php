<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Status;

new class extends Component {

};
?>

<x-general.section_with_title title="{{ __('order.pending_title') }}">
    <livewire:order.table :statusId="Status::PENDING"/>
</x-general.section_with_title>
