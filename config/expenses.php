<?php

return [
    'notifications' => [
        'database' => env('EXPENSE_NOTIFY_DB', true),
        'email' => env('EXPENSE_NOTIFY_EMAIL', false),
        'failure_queue' => env('EXPENSE_NOTIFICATION_FAILURE_QUEUE', 'failed-notifications'),
    ],
];