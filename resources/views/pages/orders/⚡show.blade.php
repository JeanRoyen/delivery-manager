<?php

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Livewire\Component;

new class extends Component {
    public Order $order;

    public function render(): View
    {
        return $this->view()->title('Delivery Manager | ' . $this->order->code);
    }
};
?>


<x-general.section_with_title title="{{
    __('order.details_title', [
    'code' => $order->code,
    'customer' => $order->customer->name,
])
}}"/>
