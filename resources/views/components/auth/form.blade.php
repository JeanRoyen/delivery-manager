<form action="{{ route('login.store') }}" method="post" class="space-y-4">
    @csrf
    <flux:input wire:model="email" label="{{ __('auth_form.email') }}" />
    <flux:input wire:model="password" label="{{ __('auth_form.password') }}" viewable/>
    <flux:button variant="primary" class="w-full mt-4" type="submit">{{ __('auth_form.login') }}</flux:button>
</form>
