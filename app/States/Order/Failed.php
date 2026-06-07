<?php

namespace App\States\Order;

class Failed extends OrderState
{
    public static string $name = 'failed';
    public static string $color = 'red';

    public function color(): string
    {
        return 'red';
    }

    public function label(): string
    {
        return __('order_status.failed');
    }
}
