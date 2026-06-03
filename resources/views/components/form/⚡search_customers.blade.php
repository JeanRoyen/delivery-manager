<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Livewire\Component;

new class extends Component {
    public string $search = '';

    #[Modelable]
    public ?int $value = null;

    public bool $open = false;

    #[Computed]
    public function customers(): Collection
    {
        return Customer::query()
            ->when(
                $this->search,
                fn ($query) => $query->where('name', 'like', '%' . $this->search . '%')
            )
            ->orderBy('name')
            ->limit(20)
            ->get();
    }

    #[Computed]
    public function selectedCustomer(): ?Customer
    {
        if (!$this->value) {
            return null;
        }

        return Customer::find($this->value);
    }

    public function updatedValue(): void
    {
        $this->open = false;
        $this->search = '';
    }

    public function clear(): void
    {
        $this->value = null;
        $this->search = '';
    }
};
?>

<div
    class="relative w-full"
    x-data="{ open: @entangle('open') }"
    @click.outside="open = false"
>
    <div
        @click="open = !open"
        class="flex items-center justify-between w-full px-3 py-2 bg-white border rounded-lg cursor-pointer transition
        {{
            $errors->has('form.customer_id')
                ? 'border-red-500 ring-1 ring-red-500'
                : 'border-gray-300 hover:border-gray-400 focus-within:ring-2 focus-within:ring-blue-500'
        }}"
    >
        <span class="{{ $this->selectedCustomer ? 'text-gray-900' : 'text-gray-400' }}">
            {{ $this->selectedCustomer?->name ?: 'Sélectionner un client...' }}
        </span>

        <div class="flex items-center gap-2">
            @if($this->selectedCustomer)

                <button
                    type="button"
                    wire:click.stop="clear"
                    class="text-gray-400 hover:text-gray-600"
                >
                    &times;
                </button>
            @endif

            <svg
                class="w-4 h-4 text-gray-400 transition-transform"
                :class="{ 'rotate-180': open }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                />
            </svg>
        </div>
    </div>

    <div
        x-show="open"
        x-transition
        class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg"
    >
        <div class="p-2 border-b border-gray-100">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Rechercher..."
                class="w-full px-3 py-1.5 text-sm border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                @click.stop
                x-init="$watch('open', value => value && setTimeout(() => $el.focus(), 50))"
            />
        </div>

        <ul class="max-h-56 overflow-y-auto py-1">
            @forelse($this->customers as $customer)
                <li wire:key="{{ $customer->id }}">
                    <label
                        class="flex items-center w-full px-3 py-2 text-sm cursor-pointer transition hover:bg-blue-50
                        {{
                            $value === $customer->id
                                ? 'bg-blue-100 text-blue-700 font-medium'
                                : 'text-gray-700'
                        }}"
                    >
                        <input
                            type="radio"
                            wire:model.live="value"
                            value="{{ $customer->id }}"
                            class="sr-only"
                        >

                        <span class="truncate">
                            {{ $customer->name }}
                        </span>
                    </label>
                </li>
            @empty
                <li class="px-3 py-2 text-sm text-gray-400">
                    Aucun résultat
                </li>
            @endforelse
        </ul>
    </div>
</div>
