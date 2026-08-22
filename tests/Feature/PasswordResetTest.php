<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('allows a user to request and reset their password', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->withSession(['locale' => 'fr'])
        ->get(route('password.request'))
        ->assertOk()
        ->assertSee(__('auth_form.forgot_password_title'));

    $this->withSession(['locale' => 'fr'])
        ->post(route('password.email'), ['email' => $user->email])
        ->assertSessionHas('status', __('passwords.sent'));

    Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user) {
        $this->withSession(['locale' => 'fr'])
            ->get(route('password.reset', [
            'token' => $notification->token,
            'email' => $user->email,
        ]))
            ->assertOk()
            ->assertSee(__('auth_form.reset_password_title'));

        $this->withSession(['locale' => 'fr'])
            ->post(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertRedirect(route('login'));

        return true;
    });

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});
