<?php

namespace App\States\Order;


use function __;

class Delivering extends OrderState
{
    public static string $name = 'delivering';
    public static string $color = 'lime';


    public function label(): string
    {
        return __('order_status.delivering');
    }

    public function color(): string
    {
        return 'lime';
    }
}
