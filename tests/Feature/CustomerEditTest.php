<?php

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('an authenticated user can see a customer page', function () {
    $customer = Customer::factory()->create();

    $this->actingAs(User::factory()->create(['locale' => 'fr']));

    $this->get(route('customer.show', $customer))
        ->assertOk()
        ->assertSee($customer->name)
        ->assertSee($customer->email)
        ->assertSee('itemtype="https://schema.org/Person"', false)
        ->assertSee('itemprop="email"', false)
        ->assertSee('itemprop="address"', false);
});

test('a customer can be updated', function () {
    $customer = Customer::factory()->create();

    $this->actingAs(User::factory()->create());

    Livewire::test('pages::customer.show', ['customer' => $customer])
        ->set('form.name', 'Nouveau nom')
        ->set('form.email', 'nouveau@example.test')
        ->set('form.address', 'Nouvelle adresse')
        ->set('form.phone', '0499000000')
        ->call('save')
        ->assertHasNoErrors();

    expect($customer->fresh())
        ->name->toBe('Nouveau nom')
        ->email->toBe('nouveau@example.test')
        ->address->toBe('Nouvelle adresse')
        ->phone->toBe('0499000000');
});
