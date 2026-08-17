<?php

use App\Mail\OrderDelivering;
use App\Models\Customer;
use App\Models\Order;
use App\States\Order\Delivering;
use App\States\Order\Preparing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('an email is queued for the customer when an order starts delivering', function () {
    Mail::fake();

    $customer = Customer::factory()->create(['email' => 'client@example.test']);
    $order = Order::factory()->for($customer)->create();

    $order->state->transitionTo(Preparing::class);

    Mail::assertNothingQueued();

    $order->state->transitionTo(Delivering::class);

    Mail::assertQueued(OrderDelivering::class, function (OrderDelivering $mail) use ($order): bool {
        return $mail->hasTo('client@example.test') && $mail->order->is($order);
    });
});

test('the delivery email contains the order information', function () {
    app()->setLocale('fr');

    $customer = Customer::factory()->create([
        'name' => 'Client Test',
        'address' => '10 rue de la Livraison',
    ]);
    $order = Order::factory()->for($customer)->create(['code' => '12345678']);

    $mail = new OrderDelivering($order);

    $mail->assertSeeInHtml('Client Test')
        ->assertSeeInHtml('12345678')
        ->assertSeeInHtml('10 rue de la Livraison');
});
