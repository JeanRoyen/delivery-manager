<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('mail.order_failed.subject', ['code' => $order->code]) }}</title>
</head>
<body style="margin: 0; padding: 24px; background: #f4f4f5; color: #27272a; font-family: Arial, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; overflow: hidden; border: 1px solid #e4e4e7; border-radius: 12px; background: #ffffff;">
        <div style="padding: 24px; background: #dc2626; color: #ffffff;">
            <h1 style="margin: 0; font-size: 24px;">
                {{ __('mail.order_failed.title') }}
            </h1>
        </div>

        <div style="padding: 24px; line-height: 1.6;">
            <p>{{ __('mail.order_failed.greeting', ['customer' => $order->customer->name]) }}</p>

            <p>{{ __('mail.order_failed.apology') }}</p>

            <div style="margin: 24px 0; padding: 16px; border-left: 4px solid #dc2626; border-radius: 8px; background: #fef2f2;">
                <p style="margin: 0 0 8px;">
                    <strong>{{ __('mail.order_failed.order') }} :</strong>
                    #{{ $order->code }}
                </p>
                <p style="margin: 0;">
                    <strong>{{ __('mail.order_failed.reason') }} :</strong>
                    {{ $order->incident_message ?: __('mail.order_failed.no_reason') }}
                </p>
            </div>

            <p>{{ __('mail.order_failed.delay') }}</p>
            <p>{{ __('mail.order_failed.thanks') }}</p>
        </div>
    </div>
</body>
</html>
