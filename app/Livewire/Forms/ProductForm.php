<?php

namespace App\Livewire\Forms;

use Akaunting\Money\Money;
use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Form;
use function str_replace;

class ProductForm extends Form
{
    #[Validate('required')]
    public $name;

    #[Validate('nullable')]
    public $description;

    #[Validate('required|decimal:2')]
    public $price;

    public function store(): void
    {
        $validated = $this->validate();

        $price = str_replace('.', '', $this->price);

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $price,
        ]);
    }
}
