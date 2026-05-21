<?php

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component {
    use Livewire\WithPagination;

    public string $search = '';
    public string $sortBy = 'id';

    public string $sortDirection = 'desc';

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
    public function products(): LengthAwarePaginator
    {
        return Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('id', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function delete(Product $product): void
    {
        if (!Auth::user()->isAdmin) {
            abort(403);
        }

        $product->delete();
        Flux::toast(__('toast.changes'));
    }
};
?>

<div>
    <x-general.section_with_title title="{{ __('product.product_list') }}">
        <div class="flex items-center justify-between gap-10">
            <flux:input
                icon="magnifying-glass"
                placeholder="{{ __('product.search_placeholder') }}"
                wire:model.live.debounce.300ms="search"
            />
            <flux:button
                variant="primary"
                color="green"
                icon="plus"
                href="{{ route('product.create') }}"
                wire:navigate
            >
                {{ __('product.add_product') }}
            </flux:button>
        </div>
        <flux:table :paginate="$this->products">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'id'" :direction="$sortDirection"
                                   wire:click="sort('id')">
                    ID
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                                   wire:click="sort('name')">
                    {{ __('product.name') }}
                </flux:table.column>
                <flux:table.column>{{ __('product.description') }}</flux:table.column>
                <flux:table.column>{{ __('product.price') }}</flux:table.column>
                @if(Auth::user()->isAdmin)
                    <flux:table.column>{{ __('product.actions') }}</flux:table.column>
                @endif
            </flux:table.columns>
            <flux:table.rows>
                @foreach($this->products as $product)
                    <flux:table.row :key="$product->id">
                        <flux:table.cell>
                            {{ $product->id }}
                        </flux:table.cell>
                        <flux:table.cell>
                            {{ Str::title($product->name) }}
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-normal wrap-break-word max-w-xs">
                            {{ $product->description }}
                        </flux:table.cell>
                        <flux:table.cell>
                            {{ money($product->price, 'EUR')}}
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

                                        <flux:menu.item icon="trash"
                                                        wire:click="delete({{ $product->id }})"
                                                        wire:confirm="{{ __('product.delete_confirm') }}{{ $product->name }}">
                                            {{ __('product.delete') }}
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
