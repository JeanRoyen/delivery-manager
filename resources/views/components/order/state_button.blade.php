@props([
    'order'
])

@if($order->state->canTransitionTo(\App\States\Order\Preparing::class))

    <flux:button
        variant="primary"
        color="blue"
        icon="play"
        wire:click="updateState('preparing', 'preparing.index')"
    >
        {{ __('order_show.order.start_preparation') }}
    </flux:button>

@elseif($order->state->canTransitionTo(\App\States\Order\Delivering::class))

    <flux:button
        variant="primary"
        color="lime"
        icon="truck"
        wire:click="updateState('delivering', 'delivering.index')"
    >
        {{ __('order_show.order.start_delivery') }}
    </flux:button>

@elseif($order->state->canTransitionTo(\App\States\Order\Delivered::class))

    <flux:button
        variant="primary"
        icon="check"
        wire:click="updateState('delivered', 'delivered.index')"
    >
        {{ __('order_show.order.mark_delivered') }}
    </flux:button>

@endif
