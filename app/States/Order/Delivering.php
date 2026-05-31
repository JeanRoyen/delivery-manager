<?php

namespace App\States\Order;


use function __;

class Delivering extends OrderState
{
    public static string $name = 'delivering';

    public function color(): string
    {
        return 'lime';
    }

    public function label(): string
    {
        return __('order_status.delivering');
    }
}
