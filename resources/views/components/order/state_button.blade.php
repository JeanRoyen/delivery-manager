@php use App\States\Order\Delivered;use App\States\Order\Delivering;use App\States\Order\Preparing; @endphp
@props([
    'order'
])

@if($order->state->canTransitionTo(Preparing::class))

    <flux:button
        variant="primary"
        color="indigo"
        icon="play"
        wire:click="updateState('preparing', 'preparing.index')"
    >
        {{ __('order_show.order.start_preparation') }}
    </flux:button>

@elseif($order->state->canTransitionTo(Delivering::class))

    <flux:button
        variant="primary"
        color="indigo"
        icon="truck"
        wire:click="updateState('delivering', 'delivering.index')"
    >
        {{ __('order_show.order.start_delivery') }}
    </flux:button>

@elseif($order->state->canTransitionTo(Delivered::class))

    <flux:button
        variant="primary"
        color="indigo"
        icon="check"
        wire:click="updateState('delivered', 'delivered.index')"
    >
        {{ __('order_show.order.mark_delivered') }}
    </flux:button>

@endif
