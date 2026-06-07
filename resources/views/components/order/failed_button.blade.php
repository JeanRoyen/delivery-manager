@php use App\States\Order\Failed @endphp
@props([
    'order'
])

@if($order->state->canTransitionTo(Failed::class))

    <flux:button
        variant="primary"
        color="red"
        icon="x-mark"
        wire:navigate
        wire:click="updateState('failed', 'failed.index')"
    >
        {{ __('order_show.order.failed_status') }}
    </flux:button>
@endif
