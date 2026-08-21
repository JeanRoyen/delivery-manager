<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = 'password';

        $employees = [
            ['first_name' => 'Élodie', 'last_name' => 'Lambert', 'email' => 'elodie.lambert@delivery-manager.test', 'isAdmin' => true, 'locale' => 'fr'],
            ['first_name' => 'Nicolas', 'last_name' => 'Dubois', 'email' => 'nicolas.dubois@delivery-manager.test', 'isAdmin' => false, 'locale' => 'fr'],
            ['first_name' => 'Anouk', 'last_name' => 'Peeters', 'email' => 'anouk.peeters@delivery-manager.test', 'isAdmin' => false, 'locale' => 'nl'],
            ['first_name' => 'Thomas', 'last_name' => 'Janssens', 'email' => 'thomas.janssens@delivery-manager.test', 'isAdmin' => false, 'locale' => 'nl'],
        ];

        foreach ($employees as $employee) {
            $user = User::query()->firstOrNew(['email' => $employee['email']]);

            $user->forceFill([
                ...$employee,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ])->save();
        }

        $firstNames = ['Sophie', 'Lucas', 'Emma', 'Hugo', 'Camille', 'Louis', 'Julie', 'Arthur', 'Chloé', 'Nathan', 'Sarah', 'Maxime'];
        $lastNames = ['Martin', 'Bernard', 'Dubois', 'Lambert', 'Leroy'];
        $streets = ['rue de la Station', 'avenue des Tilleuls', 'rue du Centre', 'chaussée de Liège', 'rue des Jardins', 'avenue du Parc'];
        $cities = [
            ['postal_code' => '4000', 'name' => 'Liège'],
            ['postal_code' => '4020', 'name' => 'Liège'],
            ['postal_code' => '4100', 'name' => 'Seraing'],
            ['postal_code' => '4430', 'name' => 'Ans'],
            ['postal_code' => '4600', 'name' => 'Visé'],
            ['postal_code' => '4800', 'name' => 'Verviers'],
        ];

        $customers = collect();

        foreach (range(0, 59) as $index) {
            $firstName = $firstNames[$index % count($firstNames)];
            $lastName = $lastNames[intdiv($index, count($firstNames))];
            $city = $cities[$index % count($cities)];
            $email = Str::slug($firstName.'.'.$lastName, '.').'@example.test';

            $customers->push(Customer::query()->updateOrCreate(
                ['email' => $email],
                [
                    'name' => $firstName.' '.$lastName,
                    'address' => ($index + 1).', '.$streets[$index % count($streets)].', '.$city['postal_code'].' '.$city['name'],
                    'phone' => sprintf('04%02d %02d %02d %02d', 70 + ($index % 10), 10 + ($index % 80), 20 + ($index % 70), 30 + ($index % 60)),
                ],
            ));
        }

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

        $states = ['pending', 'preparing', 'delivering', 'delivered', 'failed'];

        foreach (range(1, 200) as $index) {
            $state = $states[($index - 1) % count($states)];
            $createdAt = now()
                ->subDays(60 - ($index % 61))
                ->setTime(8 + ($index % 10), ($index * 7) % 60);

            $order = Order::query()->firstOrNew([
                'code' => sprintf('%08d', $index),
            ]);

            $order->forceFill([
                'customer_id' => $customers[($index - 1) % $customers->count()]->id,
                'total_amount' => 0,
                'state' => $state,
                'incident_message' => $state === 'failed' ? 'Retard causé par un incident logistique lors du transport.' : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ])->save();

            OrderItem::query()
                ->withTrashed()
                ->where('order_id', $order->id)
                ->forceDelete();

            $total = 0;
            $itemCount = 2 + (($index - 1) % 5);

            foreach (range(0, $itemCount - 1) as $itemIndex) {
                $product = $products[(($index - 1) * 3 + $itemIndex) % $products->count()];
                $quantity = 1 + (($index + $itemIndex) % 4);
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
