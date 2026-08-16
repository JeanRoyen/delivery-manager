<?php

use App\Models\Order;
use App\Models\User;
use App\States\Order\Preparing;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a state change is added to the order history', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create();

    $this->actingAs($user);

    $order->state->transitionTo(Preparing::class);

    $history = $order->histories()->sole();

    expect($history->from_state)->toBe('pending')
        ->and($history->to_state)->toBe('preparing')
        ->and($history->user_id)->toBe($user->id);
});
