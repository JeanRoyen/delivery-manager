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

    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | ' . __('pages_title.dashboard'));
    }

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
            ->with('customer'])
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
    <div class="space-y-8">
        <section>
            <h3 class="text-3xl font-bold">{{ __('dashboard.welcome', ['name' => ucfirst(Auth::user()->first_name)]) }}</h3>
        </section>
        <section class="space-y-4">
            <h3 class="text-2xl">{{ __('dashboard.fast_actions') }}</h3>
            <x-dashboard.fast-action_card-list/>
        </section>

        <section class="space-y-4">
            <h3 class="text-2xl">{{ __('dashboard.latest_modifications') }}</h3>
            <flux:table>
                <div class="flex gap-10 items-center">
                    <x-general.searchbar />
                    <livewire:order.navbar />
                </div>
                <flux:table.columns>
                    <flux:table.column align="center" sortable :sorted="$sortBy === 'code'" :direction="$sortDirection"
                                       wire:click="sort('code')">ID
                    </flux:table.column>
                    <flux:table.column align="center">{{ __('order.customer') }}</flux:table.column>
                    <flux:table.column align="center" sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                                       wire:click="sort('created_at')">{{ __('order.updated_at') }}</flux:table.column>
                    <flux:table.column align="center">{{ __('order.status') }}</flux:table.column>
                    <flux:table.column align="center">{{ __('order.total') }}</flux:table.column>

                </flux:table.columns>

                <flux:table.rows>
                    @foreach($this->orders as $order)
                        <flux:table.row align="center">
                            <flux:table.cell>
                                {{ $order->code }}
                            </flux:table.cell>
                            <flux:table.cell>
                                {{ $order->customer->name }}
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $order->updated_at->format('d/m/Y H:i') }}
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
