<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('mail.order_delivering.subject', ['code' => $order->code]) }}</title>
</head>
<body style="margin: 0; padding: 24px; background: #f4f4f5; color: #27272a; font-family: Arial, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; overflow: hidden; border: 1px solid #e4e4e7; border-radius: 12px; background: #ffffff;">
        <div style="padding: 24px; background: #16a34a; color: #ffffff;">
            <h1 style="margin: 0; font-size: 24px;">
                {{ __('mail.order_delivering.title') }}
            </h1>
        </div>

        <div style="padding: 24px; line-height: 1.6;">
            <p>{{ __('mail.order_delivering.greeting', ['customer' => $order->customer->name]) }}</p>

            <p>{{ __('mail.order_delivering.message') }}</p>

            <div style="margin: 24px 0; padding: 16px; border-radius: 8px; background: #f4f4f5;">
                <p style="margin: 0 0 8px;">
                    <strong>{{ __('mail.order_delivering.order') }} :</strong>
                    #{{ $order->code }}
                </p>
                <p style="margin: 0;">
                    <strong>{{ __('mail.order_delivering.address') }} :</strong>
                    {{ $order->customer->address }}
                </p>
            </div>

            <p>{{ __('mail.order_delivering.thanks') }}</p>
        </div>
    </div>
</body>
</html>
