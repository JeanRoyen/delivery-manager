<form action="{{ route('login.store') }}" method="post">
    @csrf
    <title>
        Formulaire de connexion
    </title>
    <x-form.input-with-label type="email" name="email" label="Email" />
    <x-form.input-with-label type="password" name="password" label="Mot de passe" />
    <button type="submit">Connexion</button>
</form>
