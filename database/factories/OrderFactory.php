<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->ean8(),
            'total_amount' => $this->faker->numberBetween(500, 50000),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'customer_id' => Customer::factory(),
        ];
    }
}
