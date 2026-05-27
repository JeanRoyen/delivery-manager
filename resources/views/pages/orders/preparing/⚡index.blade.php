<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Status;

new class extends Component {

};
?>

<x-general.section_with_title title="{{ __('order.preparing_title') }}">
    <livewire:order.table :statusId="Status::PREPARING"/>
</x-general.section_with_title>
