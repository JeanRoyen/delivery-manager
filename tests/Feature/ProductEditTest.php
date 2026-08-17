<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('an authenticated user can see a product page', function () {
    $product = Product::factory()->create(['price' => 1299]);

    $this->actingAs(User::factory()->create(['locale' => 'fr']));

    $this->get(route('product.show', $product))
        ->assertOk()
        ->assertSee($product->name)
        ->assertSee('12.99');
});

test('a product can be updated', function () {
    $product = Product::factory()->create();

    $this->actingAs(User::factory()->create());

    Livewire::test('pages::product.show', ['product' => $product])
        ->set('form.name', 'Nouveau produit')
        ->set('form.price', '24,99')
        ->set('form.description', 'Nouvelle description')
        ->call('save')
        ->assertHasNoErrors();

    expect($product->fresh())
        ->name->toBe('Nouveau produit')
        ->price->toBe(2499)
        ->description->toBe('Nouvelle description');
});
