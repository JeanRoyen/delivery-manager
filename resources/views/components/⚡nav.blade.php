<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <header>
        <nav>
            <a href="{{ route('dashboard.index') }}">Dashboard</a>
            <a href="{{ route('customer.index') }}">Customer</a>
            <a href="{{ route('order.index') }}">Order</a>
            <a href="{{ route('preparation.index') }}">Preparation</a>
            <a href="{{ route('delivery.index') }}">Delivery</a>
            <a href="{{ route('historic.index') }}">Historic</a>
        </nav>
    </header>
</div>
