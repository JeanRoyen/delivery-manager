<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an authenticated user can see the dashboard indicators', function () {
    $customer = Customer::factory()->create();
    Order::factory()->for($customer)->create();

    $this->actingAs(User::factory()->create(['locale' => 'fr']));

    $this->get(route('dashboard.index'))
        ->assertOk()
        ->assertSee(__('dashboard.overview'))
        ->assertSee(__('dashboard.pending_orders'))
        ->assertSee(__('dashboard.preparing_orders'))
        ->assertSee(__('dashboard.delivering_orders'))
        ->assertSee(__('dashboard.delivered_today'))
        ->assertSee(route('pending.index'))
        ->assertSee(route('preparing.index'))
        ->assertSee(route('delivering.index'))
        ->assertSee(route('delivered.index'))
        ->assertSee(route('customer.show', $customer));
});
