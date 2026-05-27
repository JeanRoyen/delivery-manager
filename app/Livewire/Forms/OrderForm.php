<?php

namespace App\Livewire\Forms;

use App\Enums\OrderStatus;
use App\Models\Order;
use Akaunting\Money\Money;
use Livewire\Attributes\Validate;
use Livewire\Form;
use function uniqid;

class OrderForm extends Form
{
    #[Validate('required|exists:customers,id')]
    public $customer_id;

    #[Validate('required|array|min:1')]
    public array $items = [];

    public function store(): void
    {
        $this->validate([
            'customer_id'          => 'required|exists:customers,id',
            'items'                => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.quantity'     => 'required|integer|min:1',
        ]);

        Order::create([
            'customer_id' => $this->customer_id,
            'status'      => OrderStatus::PENDING,
            'orders'      => uniqid(),
            'total'       => $this->calculateTotal(),
            'items'       => $this->items,
        ]);
    }

    public function calculateTotal(): int
    {
        return collect($this->items)->sum(function ($item) {
            $price = Money::EUR($item['price_in_cents']);
            return $price->multiply($item['quantity'])->getAmount();
        });
    }
}
