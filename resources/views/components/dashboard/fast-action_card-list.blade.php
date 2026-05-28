<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
    <x-dashboard.fast-action_card
        title="{{ __('fast-action_cards.new_customer_title') }}"
        button="{{ __('fast-action_cards.create_customer_button') }}"
        :href="route('customer.create')"
    >
        <x-slot:icon>
            <flux:icon.user class="size-10 text-zinc-700" />
        </x-slot:icon>
    </x-dashboard.fast-action_card>
    <x-dashboard.fast-action_card
        title="{{ __('fast-action_cards.new_product_title') }}"
        button="{{ __('fast-action_cards.create_product_button') }}"
        :href="route('product.create')"
    >
        <x-slot:icon>
            <flux:icon.list-bullet class="size-10 text-zinc-700" />
        </x-slot:icon>
    </x-dashboard.fast-action_card>
    <x-dashboard.fast-action_card
        title="{{ __('fast-action_cards.new_order_title') }}"
        button="{{ __('fast-action_cards.create_order_button') }}"
        :href="route('orders.create')"
    >
        <x-slot:icon>
            <flux:icon.cube class="size-10 text-zinc-700" />
        </x-slot:icon>
    </x-dashboard.fast-action_card>

</div>
