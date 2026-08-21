<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Élodie',
            'last_name' => 'Lambert',
            'email' => 'elodie.lambert@delivery-manager.test',
            'password' => 'password',
            'isAdmin' => 1,
            'locale' => 'fr',
        ]);

        User::factory()->create([
            'first_name' => 'Nicolas',
            'last_name' => 'Dubois',
            'email' => 'nicolas.dubois@delivery-manager.test',
            'password' => 'password',
            'locale' => 'fr',
        ]);

        User::factory()->create([
            'first_name' => 'Anouk',
            'last_name' => 'Peeters',
            'email' => 'anouk.peeters@delivery-manager.test',
            'password' => 'password',
            'locale' => 'nl',
        ]);

        User::factory()->create([
            'first_name' => 'Thomas',
            'last_name' => 'Janssens',
            'email' => 'thomas.janssens@delivery-manager.test',
            'password' => 'password',
            'locale' => 'nl',
        ]);

        $customers = Customer::factory()->count(200)->create();

        $products = collect([
            ['name' => 'Canapé Oslo 3 places', 'description' => 'Canapé trois places en tissu gris clair avec pieds en chêne.', 'price' => 89900],
            ['name' => 'Fauteuil Bergen', 'description' => 'Fauteuil scandinave en tissu bleu nuit avec accoudoirs.', 'price' => 34900],
            ['name' => 'Table basse Malmö', 'description' => 'Table basse ronde en chêne naturel, diamètre 80 cm.', 'price' => 21900],
            ['name' => 'Meuble TV Aarhus', 'description' => 'Meuble TV en bois clair avec deux portes et une niche centrale.', 'price' => 42900],
            ['name' => 'Bibliothèque Stockholm', 'description' => 'Bibliothèque à cinq niveaux en chêne et métal noir.', 'price' => 57900],
            ['name' => 'Table à manger Copenhague', 'description' => 'Table à manger rectangulaire pour six personnes en chêne massif.', 'price' => 74900],
            ['name' => 'Chaise Odense', 'description' => 'Chaise de salle à manger en bois avec assise rembourrée beige.', 'price' => 12900],
            ['name' => 'Buffet Helsinki', 'description' => 'Buffet bas à trois portes en bois naturel et cannage.', 'price' => 64900],
            ['name' => 'Lit double Reykjavik', 'description' => 'Cadre de lit 160 × 200 cm avec tête de lit en tissu gris.', 'price' => 69900],
            ['name' => 'Table de chevet Turku', 'description' => 'Table de chevet compacte avec un tiroir et une niche ouverte.', 'price' => 14900],
            ['name' => 'Commode Uppsala', 'description' => 'Commode en bois clair équipée de six tiroirs.', 'price' => 47900],
            ['name' => 'Armoire Göteborg', 'description' => 'Armoire deux portes avec penderie et étagères réglables.', 'price' => 84900],
            ['name' => 'Bureau Espoo', 'description' => 'Bureau en chêne avec deux tiroirs et passe-câbles intégré.', 'price' => 38900],
            ['name' => 'Chaise de bureau Lund', 'description' => 'Chaise ergonomique réglable avec soutien lombaire.', 'price' => 29900],
            ['name' => 'Étagère murale Tromsø', 'description' => 'Étagère murale en bois massif de 90 cm.', 'price' => 7900],
            ['name' => 'Console Viborg', 'description' => 'Console étroite avec deux tiroirs, idéale pour une entrée.', 'price' => 28900],
            ['name' => 'Banc Roskilde', 'description' => 'Banc en bois avec assise rembourrée pour deux personnes.', 'price' => 23900],
            ['name' => 'Meuble à chaussures Randers', 'description' => 'Meuble compact à trois compartiments pouvant accueillir douze paires.', 'price' => 19900],
            ['name' => 'Portemanteau Kiruna', 'description' => 'Portemanteau sur pied en métal noir et bois naturel.', 'price' => 9900],
            ['name' => 'Pouf Stavanger', 'description' => 'Pouf rond en tissu bouclé écru, diamètre 55 cm.', 'price' => 11900],
        ])->map(fn (array $product) => Product::query()->updateOrCreate(
            ['name' => $product['name']],
            $product,
        ));

        $orders = Order::factory()
            ->count(200)
            ->recycle($customers)
            ->sequence(
                ['state' => 'pending'],
                ['state' => 'preparing'],
                ['state' => 'delivering'],
                ['state' => 'delivered'],
                ['state' => 'failed'],
            )
            ->create();

        foreach ($orders as $order) {
            $total = 0;

            foreach ($products->random(random_int(2, 6)) as $product) {
                $quantity = random_int(1, 4);
                $lineTotal = $product->price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $lineTotal,
                ]);

                $total += $lineTotal;
            }

            $order->update(['total_amount' => $total]);
        }
    }
}
