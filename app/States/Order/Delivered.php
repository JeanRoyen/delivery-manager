<?php

namespace App\States\Order;


class Delivered extends OrderState
{
    public static string $name = 'delivered';

    public function color(): string
    {
        return 'zinc';
    }

    public function label(): string
    {
        return __('order_status.delivered');
    }
}
