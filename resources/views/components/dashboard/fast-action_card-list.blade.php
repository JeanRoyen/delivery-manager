<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
    <x-dashboard.fast-action_card
        title="{{ __('fast-action_cards.new_customer_title') }}"
        button="{{ __('fast-action_cards.create_customer_button') }}"
        :href="route('customer.create')"
        icon-class="bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300"
        button-color="violet"
    >
        <x-slot:icon>
            <flux:icon.user class="size-8" />
        </x-slot:icon>
    </x-dashboard.fast-action_card>
    <x-dashboard.fast-action_card
        title="{{ __('fast-action_cards.new_product_title') }}"
        button="{{ __('fast-action_cards.create_product_button') }}"
        :href="route('product.create')"
        icon-class="bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300"
        button-color="sky"
    >
        <x-slot:icon>
            <flux:icon.list-bullet class="size-8" />
        </x-slot:icon>
    </x-dashboard.fast-action_card>
    <x-dashboard.fast-action_card
        title="{{ __('fast-action_cards.new_order_title') }}"
        button="{{ __('fast-action_cards.create_order_button') }}"
        :href="route('orders.create')"
        icon-class="bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300"
        button-color="emerald"
    >
        <x-slot:icon>
            <flux:icon.cube class="size-8" />
        </x-slot:icon>
    </x-dashboard.fast-action_card>

</div>
