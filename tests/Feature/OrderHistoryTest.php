<?php

use App\Models\Order;
use App\Models\User;
use App\States\Order\Preparing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

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

test('an incident changes the order state and stores its message', function () {
    $user = User::factory()->create();
    $order = Order::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::orders.show', ['order' => $order])
        ->set('incidentMessage', 'Le client est absent à l’adresse indiquée.')
        ->call('reportIncident')
        ->assertHasNoErrors()
        ->assertSee('Le client est absent à l’adresse indiquée.');

    $order->refresh();

    expect((string) $order->state)->toBe('failed')
        ->and($order->incident_message)->toBe('Le client est absent à l’adresse indiquée.')
        ->and($order->histories()->where('to_state', 'failed')->count())->toBe(1);
});

test('an incident message is required', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test('pages::orders.show', ['order' => Order::factory()->create()])
        ->call('reportIncident')
        ->assertHasErrors(['incidentMessage' => 'required']);
});
