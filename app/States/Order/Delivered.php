<?php

namespace App\States\Order;


use function __;

class Delivered extends OrderState
{
    public static string $name = 'delivered';
    public static string $color = 'zinc';

    public function label(): string
    {
        return __('order_status.delivered');
    }
}
