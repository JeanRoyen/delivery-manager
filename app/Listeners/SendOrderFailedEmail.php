<?php

namespace App\Listeners;

use App\Mail\OrderFailed;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Spatie\ModelStates\Events\StateChanged;

class SendOrderFailedEmail
{
    public function handle(StateChanged $event): void
    {
        if (! $event->model instanceof Order || $event->field !== 'state') {
            return;
        }

        if ((string) $event->finalState !== 'failed') {
            return;
        }

        Mail::to($event->model->customer->email)
            ->locale(app()->getLocale())
            ->queue(new OrderFailed($event->model));
    }
}
