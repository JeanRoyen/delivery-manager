<?php

use App\Mail\OrderFailed;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use App\States\Order\Failed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('an email is queued for the customer when an order fails', function () {
    Mail::fake();

    $this->actingAs(User::factory()->create(['locale' => 'nl']));

    $customer = Customer::factory()->create(['email' => 'client@example.test']);
    $order = Order::factory()->for($customer)->create([
        'incident_message' => 'Le véhicule de livraison est en panne.',
    ]);

    $order->state->transitionTo(Failed::class);

    Mail::assertQueued(OrderFailed::class, function (OrderFailed $mail) use ($order): bool {
        return $mail->hasTo('client@example.test')
            && $mail->order->is($order)
            && $mail->locale === 'nl';
    });
});

test('the failed order email is translated into dutch', function () {
    $customer = Customer::factory()->create(['name' => 'Klant Test']);
    $order = Order::factory()->for($customer)->create([
        'code' => '12345678',
        'incident_message' => 'Het leveringsvoertuig is defect.',
    ]);

    (new OrderFailed($order))
        ->locale('nl')
        ->assertSeeInHtml('Uw levering heeft vertraging opgelopen')
        ->assertSeeInHtml('Reden van de vertraging')
        ->assertSeeInHtml('Het leveringsvoertuig is defect.')
        ->assertSeeInHtml('Uw bestelling zal iets later aankomen dan verwacht.');
});

test('the failed order email contains the incident reason', function () {
    app()->setLocale('fr');

    $customer = Customer::factory()->create(['name' => 'Client Test']);
    $order = Order::factory()->for($customer)->create([
        'code' => '12345678',
        'incident_message' => 'Le véhicule de livraison est en panne.',
    ]);

    $mail = new OrderFailed($order);

    $mail->assertSeeInHtml('Client Test')
        ->assertSeeInHtml('12345678')
        ->assertSeeInHtml('Le véhicule de livraison est en panne.')
        ->assertSeeInHtml('Votre commande arrivera un peu plus tard que prévu.');
});
