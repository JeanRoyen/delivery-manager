<?php

namespace App\States\Order;


use function __;

class Pending extends OrderState
{
    public static string $name = 'pending';

    public function color(): string
    {
        return 'yellow';
    }

    public function label(): string
    {
        return __('order_status.pending');
    }
}
