<?php

use App\Models\Order;
use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public int $statusId;

    public string $sortBy = 'created_at';

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
            ->when($this->statusId, fn($query) => $query->where('status_id', $this->statusId))
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
            ->paginate(15);
    }
}
?>
<div class="space-y-4">
    <div class="flex gap-10 items-center">
        <x-general.searchbar />
        <livewire:order.navbar />
    </div>
    <flux:table>
        <flux:table.columns>

            <flux:table.column align="center" sortable :sorted="$sortBy === 'code'" :direction="$sortDirection"
                               wire:click="sort('code')">ID
            </flux:table.column>
            <flux:table.column align="center">{{ __('order.customer') }}</flux:table.column>
            <flux:table.column align="center" sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                               wire:click="sort('created_at')">{{ __('order.created_at') }}</flux:table.column>
            <flux:table.column align="center">{{ __('order.status') }}</flux:table.column>
            <flux:table.column align="center">{{ __('order.total') }}</flux:table.column>
            <flux:table.column align="center">{{ __('order.see_order') }}</flux:table.column>

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

                    <flux:table.cell align="left">
                        <flux:button
                            size="sm"
                            icon="eye"
                            :href="route('orders.show', $order)"
                            wire:navigate
                        />
                    </flux:table.cell>

                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
    <flux:pagination :paginator="$this->orders" />
</div>

