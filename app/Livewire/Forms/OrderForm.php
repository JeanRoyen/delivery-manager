<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Form;

use function str_pad;

class OrderForm extends Form
{
    public ?int $customer_id = null;

    public array $items = [
        ['product_id' => '', 'quantity' => 1],
    ];

    protected function rules(): array
    {
        return [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'customer_id' => strtolower(__('form.customer')),
            'items' => strtolower(__('form.order_items')),
            'items.*.product_id' => strtolower(__('form.product')),
            'items.*.quantity' => strtolower(__('form.quantity')),
        ];
    }

    public function addItem(): void
    {
        $this->items[] = ['product_id' => '', 'quantity' => 1];
    }

    public function removeItem(int $index): void
    {
        if (count($this->items) === 1) {
            return;
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function store(): void
    {
        $this->validate();

        DB::transaction(function (): void {
            $order = Order::create([
                'customer_id' => $this->customer_id,
                'total_amount' => $this->calculateTotal(),
                'code' => $this->generateCode(),
            ]);

            foreach ($this->items as $item) {
                $product = Product::find($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $product->price * $item['quantity'],
                ]);
            }
        });
    }

    public function calculateTotal(): int
    {
        $total = 0;

        foreach ($this->items as $item) {
            $product = Product::find($item['product_id'] ?? null);

            if ($product) {
                $total += $product->price * ($item['quantity'] ?? 0);
            }
        }

        return $total;
    }

    public function generateCode(): string
    {
        do {
            $code = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);

        } while (Order::where('code', $code)->exists());

        return $code;
    }
}
