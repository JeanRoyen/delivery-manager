<?php

return [
    'order_delivering' => [
        'subject' => 'Your order #:code is out for delivery',
        'title' => 'Your order is on its way',
        'greeting' => 'Hello :customer,',
        'message' => 'Your order has left our premises and is now out for delivery.',
        'order' => 'Order',
        'address' => 'Delivery address',
        'thanks' => 'Thank you for your trust.',
    ],
    'order_failed' => [
        'subject' => 'Delay concerning your order #:code',
        'title' => 'Your delivery has encountered a delay',
        'greeting' => 'Hello :customer,',
        'apology' => 'We are sorry, an incident is preventing us from delivering your order as planned.',
        'order' => 'Order',
        'reason' => 'Reason for the delay',
        'no_reason' => 'An unexpected incident has occurred.',
        'delay' => 'Your order will arrive a little later than expected. Our team is working to resolve the situation as quickly as possible.',
        'thanks' => 'Please accept our apologies for the inconvenience, and thank you for your understanding.',
    ],
];
