<?php

use App\Livewire\Forms\OrderForm;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public OrderForm $form;

    #[Computed]
    public function customers(): Collection
    {
        return Customer::all();
    }

    #[Computed]
    public function products(): Collection
    {
        return Product::all();
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect(route('pending.index'));
    }
};
?>

<x-general.section_with_title title="Créer une commande">

    <livewire:form.search_customers/>

</x-general.section_with_title>
