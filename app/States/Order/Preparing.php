<?php

namespace App\States\Order;


use function __;

class Preparing extends OrderState
{
    public static string $name = 'preparing';
    public static string $color = 'sky';

    public function label(): string
    {
        return __('order_status.preparing');
    }

    public function color()
    {
      return 'sky';
    }
}
