<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    <header>
        <nav>
            <livewire:nav.nav-item name="Dashboard" route="/dashboard"/>
            <livewire:nav.nav-item name="Customer" route="/customer"/>
            <livewire:nav.nav-item name="Order" route="/order"/>
            <livewire:nav.nav-item name="Preparation" route="/preparation"/>
            <livewire:nav.nav-item name="Delivery" route="/delivery"/>
            <livewire:nav.nav-item name="History" route="/historic"/>
            @auth
                <form action="{{ route('logout') }}" method="post">
                    <button type="submit">Se déconnecter</button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login.store') }}">Se connecter</a>
            @endguest

        </nav>
    </header>
</div>
