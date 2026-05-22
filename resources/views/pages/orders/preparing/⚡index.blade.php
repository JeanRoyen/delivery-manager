<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

};
?>

<x-general.section_with_title title="{{ __('order.preparing_title') }}">
    <livewire:order.table :status="OrderStatus::PREPARING"/>
</x-general.section_with_title>
