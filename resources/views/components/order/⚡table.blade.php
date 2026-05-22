<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public ?OrderStatus $status = null;
    public string $search = '';

    public function updatedSearch($page): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function orders(): LengthAwarePaginator
    {
        // Cette query permet de rechercher un utilisateur par son nom et également par un ID sans rechercher les id ressemblant avec un status différent, si le composant est appelé sans valeur dans $status : il retournera la liste des commandes dans l'historique.

        return Order::query()
            ->with(['customer', 'items'])
            ->when($this->status, function (Builder $query) {
                $query->where('status', $this->status);
            })
            ->when(!$this->status, function (Builder $query) {
                $query->where('status', '!=', OrderStatus::DELIVERED);
            })
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $q) {
                    $q->where('id', 'like', "%{$this->search}%")
                        ->orWhereHas('customer', function (Builder $customer) {
                            $customer->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10);
    }
}
?>
<div>
    <x-general.searchbar/>
    <flux:table>
        <flux:table.columns>

            <flux:table.column>ID</flux:table.column>
            <flux:table.column>{{ __('order.customer') }}</flux:table.column>
            <flux:table.column>{{ __('order.created_at') }}</flux:table.column>
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
                        <flux:badge color="{{ $order->status->badgeColor() }}">
                            {{ $order->status->label() }}
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
</div>

