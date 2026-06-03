<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use Akaunting\Money\Money;
use App\Models\Status;
use Livewire\Attributes\Validate;
use Livewire\Form;
use function str_pad;

class OrderForm extends Form
{
    #[Validate('required')]
    public $customer_id;

    #[Validate('required')]
    public $total_amount;

    public function store(): void
    {
        $this->validate();
        Order::create([
            'customer_id' => $this->customer_id,
            'status_id' => Status::PENDING,
            'total_amount' => $this->total_amount,
            'code' => $this->generateCode(),
        ]);
    }

    public function calculateTotal(): int
    {
        return collect($this->items)->sum(function ($item) {
            $price = Money::EUR($item['price_in_cents']);
            return $price->multiply($item['quantity'])->getAmount();
        });
    }

    public function generateCode(): string
    {
        do {
            $code = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

        } while (Order::where('code', $code)->exists());
        return $code;
    }
}
