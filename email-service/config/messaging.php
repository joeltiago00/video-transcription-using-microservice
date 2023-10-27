<?php

return [
    'default' => env('MESSAGING_DRIVER', 'rabbitmq'),

    'connections' => [

        'rabbitmq' => [
            'host' => env('RABBITMQ_HOST', 'rabbitmq'),
            'port' => env('RABBITMQ_PORT', 5672),
            'user' => env('RABBITMQ_USER', 'rabbitmq'),
            'password' => env('RABBITMQ_PASSWORD', 'rabbitmq'),
            'vhost' => env('RABBITMQ_VHOST', '/'),
            'channels' => [
                'default' => [
                    'exchange' => env('RABBITMQ_EXCHANGE', 'email_service'),
                    'queue' => env('RABBITMQ_QUEUE', 'email_queue')
                ],
            ]
        ],
    ]
];
