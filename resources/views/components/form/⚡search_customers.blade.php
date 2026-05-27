<?php

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    public string $search = '';
    public ?int $selectedCustomerId = null;
    public string $selectedCustomerName = '';
    public string $selectedCustomerPhone = '';
    public string $selectedCustomerEmail = '';

    #[Computed]
    public function customers(): Collection
    {
        return Customer::query()
            ->when($this->search, fn($q) => $q
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->orderBy('name', 'asc')
            ->get();
    }

    public function selectCustomer(Customer $customer): void
    {
        $this->selectedCustomerId = $customer->id;
        $this->selectedCustomerName = $customer->name;
        $this->selectedCustomerEmail = $customer->email;
        $this->selectedCustomerPhone = $customer->phone;
        $this->search = '';
    }

    public function clearCustomer(): void
    {
        $this->selectedCustomerId = null;
        $this->selectedCustomerName = '';
        $this->selectedCustomerEmail = '';
        $this->search = '';
    }
};
?>

<div
    x-data="{ open: false }"
    @click.outside="open = false"
    class="relative"
>
    <flux:field>
        <flux:label>Client</flux:label>

        {{-- Card client sélectionné --}}
        <div
            x-show="$wire.selectedCustomerId"
            class="flex items-center justify-between w-full border border-zinc-200 rounded-lg px-4 py-2.5 bg-zinc-50"
        >
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-zinc-800">{{ $selectedCustomerName }}</span>
                <p class="text-xs text-zinc-400">{{ $selectedCustomerEmail }} - {{ $selectedCustomerPhone }}</p>
            </div>
            <flux:button type="button" icon="x-mark" size="sm" variant="ghost" wire:click="clearCustomer" />
        </div>

        {{-- Input + Dropdown --}}
        <div x-show="!$wire.selectedCustomerId">
            <flux:input
                wire:model.live.debounce.300ms="search"
                @focus="open = true"
                placeholder="Rechercher un client..."
                icon="magnifying-glass"
            />

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-cloak
                class="absolute left-0 top-full w-full bg-white border border-zinc-200 rounded-lg mt-1 max-h-56 overflow-y-auto z-50 shadow-lg divide-y divide-zinc-100"
            >
                @forelse($this->customers as $customer)
                    <div
                        wire:key="customer-{{ $customer->id }}"
                        wire:click="selectCustomer({{ $customer->id }})"
                        @click="open = false"
                        class="flex items-center gap-3 px-4 py-2.5 hover:bg-zinc-50 cursor-pointer"
                    >
                        <p class="text-sm font-medium text-zinc-800">{{ $customer->name }}</p>
                        <p class="text-xs text-zinc-400">{{ $customer->email }} - {{ $customer->phone }}</p>
                    </div>
                @empty
                    <div class="px-4 py-6 text-sm text-zinc-400 text-center">
                        Aucun client trouvé pour "{{ $search }}"
                    </div>
                @endforelse
            </div>
        </div>

        <flux:error name="selectedCustomerId" />
    </flux:field>
</div>
