<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Form;
use function __;
use function strtolower;

class CustomerForm extends Form
{
    #[Validate('required')]
    public $name;

    #[Validate('required')]
    public $email;

    #[Validate('required')]
    public $address;

    #[Validate('nullable')]
    public $phone;

    public function validationAttributes(): array
    {
        return [
            'name' => strtolower(__('form.name')),
            'email' => strtolower(__('form.email')),
            'address' => strtolower(__('form.address')),
            'phone' => strtolower(__('form.phone')),
        ];
    }

    public function store(): void
    {
        $validated = $this->validate();


        Customer::create($validated);
    }
}
