<?php

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('an order is created with its items and calculated total', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $firstProduct = Product::factory()->create(['price' => 1250]);
    $secondProduct = Product::factory()->create(['price' => 499]);

    $this->actingAs($user);

    Livewire::test('pages::orders.create')
        ->set('form.customer_id', $customer->id)
        ->set('form.items', [
            ['product_id' => $firstProduct->id, 'quantity' => 2],
            ['product_id' => $secondProduct->id, 'quantity' => 3],
        ])
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('pending.index'));

    $order = Order::query()->with('items')->sole();

    expect($order->customer_id)->toBe($customer->id)
        ->and($order->total_amount)->toBe(3997)
        ->and($order->items)->toHaveCount(2)
        ->and($order->items->firstWhere('product_id', $firstProduct->id)->unit_price)->toBe(1250)
        ->and($order->items->firstWhere('product_id', $firstProduct->id)->total_price)->toBe(2500);
});

test('a customer and at least one valid item are required', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test('pages::orders.create')
        ->set('form.items.0.quantity', 0)
        ->call('save')
        ->assertHasErrors([
            'form.customer_id' => 'required',
            'form.items.0.product_id' => 'required',
            'form.items.0.quantity' => 'min',
        ]);
});

test('the selected customer details are displayed', function () {
    $customer = Customer::factory()->create([
        'name' => 'Client Test',
        'email' => 'client@example.test',
        'address' => '10 rue de la Livraison',
        'phone' => '0123456789',
    ]);

    $this->actingAs(User::factory()->create());

    Livewire::test('pages::orders.create')
        ->set('form.customer_id', $customer->id)
        ->assertSee('Client Test')
        ->assertSee('client@example.test')
        ->assertSee('10 rue de la Livraison')
        ->assertSee('0123456789');
});
