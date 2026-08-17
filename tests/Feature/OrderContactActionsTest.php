<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the order page displays the customer contact actions', function () {
    $customer = Customer::factory()->create([
        'email' => 'client@example.test',
        'phone' => '0123456789',
        'address' => '10 rue de la Livraison',
    ]);

    $order = Order::factory()->for($customer)->create();

    $this->actingAs(User::factory()->create(['locale' => 'fr']));

    $this->get(route('orders.show', $order))
        ->assertOk()
        ->assertSee('mailto:client@example.test', false)
        ->assertSee('tel:0123456789', false)
        ->assertSee('https://www.google.com/maps/search/', false);
});
