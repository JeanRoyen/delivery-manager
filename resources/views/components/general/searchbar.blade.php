<flux:input
    icon="magnifying-glass"
    placeholder="{{ __('customer.search_placeholder') }}"
    wire:model.live.debounce.300ms="search"
    clearable
/>
