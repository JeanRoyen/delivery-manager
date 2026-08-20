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

        $locale = auth()->user()?->locale ?? app()->getLocale();

        Mail::to($event->model->customer->email)
            ->queue((new OrderDelivering($event->model))->locale($locale));
    }
}
