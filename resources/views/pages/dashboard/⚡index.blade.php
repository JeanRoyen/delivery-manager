<?php

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Status;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;


    public string $sortBy = 'updated_at';

    public string $sortDirection = 'desc';

    public string $search = '';

    public function updatedSearch($page): void
    {
        $this->resetPage();
    }

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    #[Computed]
    public function orders(): LengthAwarePaginator
    {
        return Order::query()
            ->with(['status', 'customer'])
            ->when(Status::DELIVERED, fn($query) => $query->whereNot('status_id', Status::DELIVERED))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', "%{$this->search}%")
                        ->orWhere('id', 'like', "%{$this->search}%")
                        ->orWhereHas('customer', function ($customer) {
                            $customer->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(5);
    }
};
?>

<x-general.section_with_title title="{{ __('sidebar.dashboard') }}">
    <div class="space-y-4">
        <section>
            <h3>{{ __('dashboard.welcome', ['name' => ucfirst(Auth::user()->first_name)]) }}</h3>
        </section>
        <section class="space-y-4">
            <h3>Actions rapides</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                <x-general.fast-action_card
                    title="Un nouveau client ? "
                    button="Créer un client"
                    :href="route('customer.create')"
                >
                    <x-slot:icon>
                        <flux:icon.user class="size-10 text-zinc-700" />
                    </x-slot:icon>
                </x-general.fast-action_card>
                <x-general.fast-action_card
                    title="Un nouveau produit ?"
                    button="Créer un produit"
                    :href="route('product.create')"
                >
                    <x-slot:icon>
                        <flux:icon.list-bullet class="size-10 text-zinc-700" />
                    </x-slot:icon>
                </x-general.fast-action_card>
                <x-general.fast-action_card
                    title="Une nouvelle commande ?"
                    button="Créer une commande"
                    :href="route('orders.create')"
                >
                    <x-slot:icon>
                        <flux:icon.cube class="size-10 text-zinc-700" />
                    </x-slot:icon>
                </x-general.fast-action_card>

            </div>
        </section>

        <section>
            <h3>Dernière modifications de status des commandes</h3>
            <flux:table>
                <div class="flex gap-10 items-center">
                    <x-general.searchbar />
                    <livewire:order.navbar />
                </div>
                <flux:table.columns>

                    <flux:table.column sortable :sorted="$sortBy === 'code'" :direction="$sortDirection"
                                       wire:click="sort('code')">ID
                    </flux:table.column>
                    <flux:table.column>{{ __('order.customer') }}</flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                                       wire:click="sort('created_at')">{{ __('order.updated_at') }}</flux:table.column>
                    <flux:table.column>{{ __('order.status') }}</flux:table.column>
                    <flux:table.column>{{ __('order.total') }}</flux:table.column>

                </flux:table.columns>

                <flux:table.rows>
                    @foreach($this->orders as $order)
                        <flux:table.row>

                            <flux:table.cell>
                                {{ $order->code }}
                            </flux:table.cell>
                            <flux:table.cell>
                                {{ $order->customer->name }}
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:badge color="{{ $order->status->color }}">
                                    {{ __('order_status.' . $order->status->label) }}
                                </flux:badge>
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ money($order->total_amount, 'EUR') }}
                            </flux:table.cell>

                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
            <flux:pagination :paginator="$this->orders" />
        </section>
    </div>


</x-general.section_with_title>
