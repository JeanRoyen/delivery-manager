<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

}
?>

<x-general.section_with_title title="{{ __('sidebar.dashboard') }}">

    <livewire:order.table/>

</x-general.section_with_title>
