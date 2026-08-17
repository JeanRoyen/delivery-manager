<?php

return [
    'order_delivering' => [
        'subject' => 'Uw bestelling #:code is onderweg',
        'title' => 'Uw bestelling is onderweg',
        'greeting' => 'Hallo :customer,',
        'message' => 'Uw bestelling heeft ons bedrijf verlaten en wordt nu geleverd.',
        'order' => 'Bestelling',
        'address' => 'Leveringsadres',
        'thanks' => 'Bedankt voor uw vertrouwen.',
    ],
    'order_failed' => [
        'subject' => 'Vertraging van uw bestelling #:code',
        'title' => 'Uw levering heeft vertraging opgelopen',
        'greeting' => 'Hallo :customer,',
        'apology' => 'Het spijt ons, maar door een incident kunnen wij uw bestelling niet leveren zoals gepland.',
        'order' => 'Bestelling',
        'reason' => 'Reden van de vertraging',
        'no_reason' => 'Er is een onverwacht incident opgetreden.',
        'delay' => 'Uw bestelling zal iets later aankomen dan verwacht. Ons team werkt eraan om de situatie zo snel mogelijk op te lossen.',
        'thanks' => 'Onze excuses voor het ongemak en bedankt voor uw begrip.',
    ],
];
