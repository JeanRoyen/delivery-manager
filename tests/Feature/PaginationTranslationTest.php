<?php

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the pagination summary is translated in french', function () {
    Customer::factory()->count(11)->create();

    $this->actingAs(User::factory()->create(['locale' => 'fr']));

    $this->get(route('customer.index'))
        ->assertOk()
        ->assertSee('Affichage de 1 à 10 sur 11 résultats');
});
