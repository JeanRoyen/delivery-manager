<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {

}
?>

<div class="space-y-6">

    <livewire:dashboard.cards_list />

    <livewire:order.table/>

</div>
