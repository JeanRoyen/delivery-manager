<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('names the login document and its landmarks', function () {
    $response = $this->withSession(['locale' => 'fr'])->get(route('login'));

    $response
        ->assertOk()
        ->assertSee('<title>Delivery Manager | Connexion</title>', false)
        ->assertSee('aria-labelledby="login-title"', false)
        ->assertSee('aria-label="Choix de la langue"', false)
        ->assertSee('title="Choix de la langue"', false)
        ->assertSee('<h2 class="sr-only">Choix de la langue</h2>', false);

    expect(substr_count($response->getContent(), '<body'))->toBe(1);
});

it('names the application landmarks', function () {
    $this->actingAs(User::factory()->create(['locale' => 'fr']));

    $this->get(route('dashboard.index'))
        ->assertOk()
        ->assertSee('aria-label="Contenu principal"', false)
        ->assertSee('aria-label="Navigation principale"', false)
        ->assertSee('aria-label="Choix de la langue"', false)
        ->assertSee('aria-label="Menu utilisateur"', false)
        ->assertSee('aria-label="Navigation par statut des commandes"', false)
        ->assertSee('title="Contenu principal"', false)
        ->assertSee('title="Navigation principale"', false)
        ->assertSee('title="Choix de la langue"', false)
        ->assertSee('title="Menu utilisateur"', false)
        ->assertSee('title="Navigation par statut des commandes"', false)
        ->assertSee('<h1 class="sr-only">Delivery Manager | Tableau de bord</h1>', false)
        ->assertSee('<h2 class="sr-only">Navigation principale</h2>', false)
        ->assertSee('<h2 class="sr-only">Choix de la langue</h2>', false)
        ->assertSee('<h2 class="sr-only">Menu utilisateur</h2>', false)
        ->assertSee('<h2 class="sr-only">Navigation par statut des commandes</h2>', false);
});
