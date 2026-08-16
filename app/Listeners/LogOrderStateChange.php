<?php

namespace App\Listeners;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Spatie\ModelStates\Events\StateChanged;

class LogOrderStateChange
{
    public function handle(StateChanged $event): void
    {
        if (! $event->model instanceof Order || $event->field !== 'state') {
            return;
        }

        $event->model->histories()->create([
            'user_id' => Auth::id(),
            'from_state' => (string) $event->initialState,
            'to_state' => (string) $event->finalState,
        ]);
    }
}
