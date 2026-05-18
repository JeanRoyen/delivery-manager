<?php

use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;


new class extends Component {
    use Livewire\WithPagination;

    public string $search = '';
    public string $sortBy = 'id';

    public string $sortDirection = 'asc';

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
    }

    #[Computed]
    public function customers(): LengthAwarePaginator
    {
        return Customer::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('address', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }


    public function delete(Customer $customer): void
    {
        if (!Auth::user()->isAdmin) {
            abort(403);
        }

        $customer->delete();
        Flux::toast(__('toast.changes'));
    }
};
?>

<div>
    <x-general.section_with_title title="{{ __('customer.customer_list') }}">
        <div class="flex items-center justify-between gap-10">
            <flux:input
                icon="magnifying-glass"
                placeholder="{{ __('customer.search_placeholder') }}"
                wire:model.live.debounce.300ms="search"
            />

            <flux:button
                variant="primary"
                color="green"
                icon="plus"
                href="{{ route('customer.create') }}"
                wire:navigate
            >
                {{ __('customer.add_customer') }}
            </flux:button>
        </div>
        <flux:table :paginate="$this->customers">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection"
                                   wire:click="sort('id')">ID</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                                   wire:click="sort('name')">{{ __('customer.customer_name') }}
                </flux:table.column>
                <flux:table.column>{{ __('customer.address') }}</flux:table.column>
                <flux:table.column>{{ __('customer.email') }}</flux:table.column>
                <flux:table.column>{{ __('customer.phone') }}</flux:table.column>
                @if(Auth::user()->isAdmin)
                    <flux:table.column>{{ __('customer.actions') }}</flux:table.column>
                @endif
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
                        @if(Auth::user()->isAdmin)
                            <flux:table.cell>
                                <flux:dropdown>
                                    <flux:button
                                        variant="ghost"
                                        size="sm"
                                        icon="ellipsis-vertical"
                                        inset="top bottom"
                                    />
                                    <flux:menu>
                                        <flux:menu.item icon="trash" wire:click="delete({{ $customer->id }})">
                                            {{ __('customer.delete') }}
                                        </flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </x-general.section_with_title>
</div>
