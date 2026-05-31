<?php

namespace App\States\Order;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
use App\Models\Order;

/**
 * @extends State<Order>
 */
abstract class OrderState extends State
{
    /**
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Preparing::class)
            ->allowTransition(Preparing::class, Delivering::class)
            ->allowTransition(Delivering::class, Delivered::class);
    }
}
