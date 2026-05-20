<?php

namespace App\Livewire\Forms;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Form;
use function __;
use function strtolower;

class ProductForm extends Form
{
    #[Validate('required')]
    public $name;

    #[Validate('nullable')]
    public $description;

    #[Validate('required|regex:/^\d+([.,]\d{1,2})?$/')]
    public $price;

    public function validationAttributes(): array
    {
        return [
            'name' => strtolower(__('form.name')),
            'description' => strtolower(__('form.description')),
            'price' => strtolower(__('form.price')),
        ];
    }


    public function store(): void
    {
        $validated = $this->validate();

        $validated['price'] = $this->normalizePrice($this->price);

        Product::create($validated);
    }

    /* Permet de récuperer le prix du formulaire avec virgule, point et vide en entrant le prix en centimes dans la base de données. */
    private function normalizePrice(string $price): int
    {
        $price = str_replace(' ', '', $price);

        $price = str_replace(',', '.', $price);

        return (int)round(((float)$price) * 100);
    }

}
