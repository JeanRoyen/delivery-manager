<?php

namespace Database\Seeders;

use App\Models\Customer;
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
            'first_name' => 'jean',
            'last_name' => 'royen',
            'email' => 'jean@test.be',
            'password' => 'test',
        ]);
        User::factory()->create([
            'first_name' => 'samantha',
            'last_name' => 'claes',
            'email' => 'sam@test.be',
            'password' => 'test',
        ]);

        Customer::factory()->count(20)->create();

    }
}
