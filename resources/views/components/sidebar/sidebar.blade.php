<flux:sidebar
    sticky
    collapsible="mobile"
    class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700"
>
    <x-sidebar.nav_menu />

    <flux:sidebar.spacer />

    <x-general.button_new href="{{ route('orders.create') }}">
        {{ __('sidebar.new_command') }}
    </x-general.button_new>

    <livewire:sidebar.avatar_dropdown/>

    <flux:switch x-data x-model="$flux.dark" label="{{ __('sidebar.dark_mode') }}" />

    <x-sidebar.language_dropdown/>




</flux:sidebar>
