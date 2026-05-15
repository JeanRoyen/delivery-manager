<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Form;

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

    public function store(): void
    {
       $validated = $this->validate();


        Customer::create($validated);
    }
}
