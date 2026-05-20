<?php

namespace App\Enums;

use function __;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PREPARING = 'preparing';
    case DELIVERING = 'delivering';
    case DELIVERED = 'delivered';

    public function label():string
    {
      return match ($this) {
          self::PENDING => __('order_status.pending'),
          self::PREPARING => __('order_status.preparing'),
          self::DELIVERING => __('order_status.delivering'),
          self::DELIVERED => __('order_status.delivered'),
      };
    }

}
