<?php

namespace App\Listeners;

use App\Mail\OrderDelivering;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Spatie\ModelStates\Events\StateChanged;

class SendOrderDeliveringEmail
{
    public function handle(StateChanged $event): void
    {
        if (! $event->model instanceof Order || $event->field !== 'state') {
            return;
        }

        if ((string) $event->finalState !== 'delivering') {
            return;
        }

        Mail::to($event->model->customer->email)
            ->locale(app()->getLocale())
            ->queue(new OrderDelivering($event->model));
    }
}
