<form action="{{ route('login.store') }}" method="post">
    @csrf
    <title>
        Formulaire de connexion
    </title>
    <flux:input wire:model="email" label="Email" />
    <flux:input wire:model="password" label="Mot de passe" viewable/>
    <button type="submit">Connexion</button>
</form>
