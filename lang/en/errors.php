<?php

return [
    '403' => [
        'page_title' => 'Access denied',
        'heading' => 'This area is not on your route',
        'description' => 'You do not have permission to view this page. Return to the dashboard to continue your work.',
        'back_to_dashboard' => 'Back to dashboard',
    ],
    '404' => [
        'page_title' => 'Page not found',
        'heading' => 'This delivery took a wrong turn',
        'description' => 'The page you are looking for cannot be found or is no longer available. Return to the dashboard to continue your route.',
        'back_to_dashboard' => 'Back to dashboard',
    ],
    '500' => [
        'page_title' => 'Internal error',
        'heading' => 'An unexpected issue is delaying the delivery',
        'description' => 'An unexpected error occurred. Please try again in a few moments or return to the dashboard.',
        'back_to_dashboard' => 'Back to dashboard',
    ],
];
