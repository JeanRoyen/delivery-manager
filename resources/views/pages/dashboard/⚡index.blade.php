<?php

use App\Models\Order;
use App\Models\OrderHistory;
use App\States\Order\Delivering;
use App\States\Order\Pending;
use App\States\Order\Preparing;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $sortBy = 'updated_at';

    public string $sortDirection = 'desc';

    public string $search = '';

    public function render()
    {
        return $this->view()
            ->title('Delivery Manager | '.__('pages_title.dashboard'));
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
    public function pendingOrders(): int
    {
        return Order::whereState('state', Pending::class)->count();
    }

    #[Computed]
    public function preparingOrders(): int
    {
        return Order::whereState('state', Preparing::class)->count();
    }

    #[Computed]
    public function deliveringOrders(): int
    {
        return Order::whereState('state', Delivering::class)->count();
    }

    #[Computed]
    public function deliveredToday(): int
    {
        return OrderHistory::query()
            ->where('to_state', 'delivered')
            ->whereDate('created_at', today())
            ->count();
    }

    #[Computed]
    public function orders(): LengthAwarePaginator
    {
        return Order::query()
            ->with('customer')
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
            ->paginate(10);
    }
};
?>

<x-general.section_with_title title="{{ __('sidebar.dashboard') }}">
    <div class="space-y-8">
        <section>
            <h3 class="text-3xl font-bold">{{ __('dashboard.welcome', ['name' => ucfirst(Auth::user()->first_name)]) }}</h3>
        </section>

        <section class="space-y-4">
            <h3 class="text-2xl">{{ __('dashboard.overview') }}</h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <x-dashboard.indicator_card
                    :title="__('dashboard.pending_orders')"
                    :value="$this->pendingOrders"
                    :href="route('pending.index')"
                    icon-class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300"
                >
                    <x-slot:icon>
                        <flux:icon.clock class="size-6" />
                    </x-slot:icon>
                </x-dashboard.indicator_card>

                <x-dashboard.indicator_card
                    :title="__('dashboard.preparing_orders')"
                    :value="$this->preparingOrders"
                    :href="route('preparing.index')"
                    icon-class="bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300"
                >
                    <x-slot:icon>
                        <flux:icon.cube class="size-6" />
                    </x-slot:icon>
                </x-dashboard.indicator_card>

                <x-dashboard.indicator_card
                    :title="__('dashboard.delivering_orders')"
                    :value="$this->deliveringOrders"
                    :href="route('delivering.index')"
                    icon-class="bg-lime-100 text-lime-700 dark:bg-lime-900/40 dark:text-lime-300"
                >
                    <x-slot:icon>
                        <flux:icon.truck class="size-6" />
                    </x-slot:icon>
                </x-dashboard.indicator_card>

                <x-dashboard.indicator_card
                    :title="__('dashboard.delivered_today')"
                    :value="$this->deliveredToday"
                    :href="route('delivered.index')"
                    icon-class="bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300"
                >
                    <x-slot:icon>
                        <flux:icon.check class="size-6" />
                    </x-slot:icon>
                </x-dashboard.indicator_card>
            </div>
        </section>

        <section class="space-y-4">
            <h3 class="text-2xl">{{ __('dashboard.fast_actions') }}</h3>
            <x-dashboard.fast-action_card-list />
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
                    <flux:table.column align="center" sortable :sorted="$sortBy === 'created_at'"
                                       :direction="$sortDirection"
                                       wire:click="sort('created_at')">{{ __('order.updated_at') }}</flux:table.column>
                    <flux:table.column align="center">{{ __('order.status') }}</flux:table.column>
                    <flux:table.column align="center">{{ __('order.total') }}</flux:table.column>

                </flux:table.columns>

                <flux:table.rows>
                    @foreach($this->orders as $order)
                        <flux:table.row align="center">
                            <flux:table.cell>
                                <flux:link :href="route('orders.show', $order)">{{ $order->code }} </flux:link>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:link :href="route('orders.show', $order)">{{ $order->customer->name }} </flux:link>
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $order->updated_at->format('d/m/Y H:i') }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:badge color="{{ $order->state->color() }}">
                                    {{ __($order->state->label()) }}
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
