<form action="{{ route('login.store') }}" method="post" class="space-y-4">
    @csrf
    <flux:input type="text" wire:model="email" label="{{ __('auth_form.email') }}" />
    <flux:input type="password" wire:model="password" label="{{ __('auth_form.password') }}" viewable="true"/>

    <div class="flex justify-end">
        <flux:link :href="route('password.request')">
            {{ __('auth_form.forgot_password') }}
        </flux:link>
    </div>

    <flux:button variant="primary" class="w-full mt-4" type="submit">{{ __('auth_form.login') }}</flux:button>
</form>
