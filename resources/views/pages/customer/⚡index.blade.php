<?php

use App\Models\Customer;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public string $search = '';

    #[Computed]
    public function customers(): Collection
    {
        return Customer::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('address', 'like', "%{$this->search}%");
            })
            ->get();
    }

    public function delete(Customer $customer): void
    {
        $customer->delete();
    }
};
?>

<div>
    <flux:input icon="magnifying-glass" placeholder="Search..." wire:model.live.debounce.300ms="search"/>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Identifiant</flux:table.column>
            <flux:table.column>Nom du client</flux:table.column>
            <flux:table.column>Adresse</flux:table.column>
            <flux:table.column>Adresse mail</flux:table.column>
            <flux:table.column>N° de téléphone</flux:table.column>
            <flux:table.column>Actions</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($this->customers as $customer)
                <flux:table.row :key="$customer->id">
                    <flux:table.cell>
                        {{ $customer->id }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ Str::title($customer->name) }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $customer->address }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $customer->email }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $customer->phone }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button
                                variant="ghost"
                                size="sm"
                                icon="ellipsis-vertical"
                                inset="top bottom"
                            />
                            <flux:menu>
                                <flux:menu.item icon="trash" wire:click="delete({{ $customer->id }})">Supprimer
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
