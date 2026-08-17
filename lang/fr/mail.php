<?php

return [
    'order_delivering' => [
        'subject' => 'Votre commande #:code est en livraison',
        'title' => 'Votre commande est en route',
        'greeting' => 'Bonjour :customer,',
        'message' => 'Votre commande vient de quitter notre établissement et est maintenant en cours de livraison.',
        'order' => 'Commande',
        'address' => 'Adresse de livraison',
        'thanks' => 'Merci pour votre confiance.',
    ],
    'order_failed' => [
        'subject' => 'Retard concernant votre commande #:code',
        'title' => 'Votre livraison rencontre un contretemps',
        'greeting' => 'Bonjour :customer,',
        'apology' => 'Nous sommes désolés, un incident nous empêche de livrer votre commande comme prévu.',
        'order' => 'Commande',
        'reason' => 'Raison du retard',
        'no_reason' => 'Un incident imprévu est survenu.',
        'delay' => 'Votre commande arrivera un peu plus tard que prévu. Notre équipe fait le nécessaire pour résoudre la situation au plus vite.',
        'thanks' => 'Veuillez accepter toutes nos excuses pour ce désagrément et merci pour votre compréhension.',
    ],
];
