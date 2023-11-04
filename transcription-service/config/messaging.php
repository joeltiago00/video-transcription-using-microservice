<?php

return [
    'default' => env('MESSAGING_DRIVER', 'rabbitmq'),

    'connections' => [

        'rabbitmq' => [
            'host' => env('RABBITMQ_HOST', 'rabbitmq'),
            'port' => env('RABBITMQ_PORT', '5672'),
            'user' => env('RABBITMQ_USER', 'rabbitmq'),
            'password' => env('RABBITMQ_PASSWORD', 'rabbitmq'),
            'vhost' => env('RABBITMQ_VHOST', '/'),
            'channels' => [
                'upload' => [
                    'exchange' => [
                        'name' => env('RABBITMQ_EXCHANGE_NAME', 'upload_service'),
                        'type' => env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
                        'is_passive' => env('RABBITMQ_EXCHANGE_PASSIVE', false),
                        'is_durable' => env('RABBITMQ_EXCHANGE_DURABLE', true),
                        'is_auto_delete' => env('RABBITMQ_EXCHANGE_AUTO_DELETE', false),
                    ],
                    'queue' => [
                        'name' => env('RABBITMQ_QUEUE_NAME', 'upload_queue'),
                        'is_passive' => env('RABBITMQ_QUEUE_PASSIVE', false),
                        'is_durable' => env('RABBITMQ_QUEUE_DURABLE', true),
                        'is_auto_delete' => env('RABBITMQ_QUEUE_AUTO_DELTE', false),
                    ]
                ],

                'email' => [
                    'exchange' => [
                        'name' => env('RABBITMQ_EXCHANGE_NAME', 'email_service'),
                        'type' => env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
                        'is_passive' => env('RABBITMQ_EXCHANGE_PASSIVE', false),
                        'is_durable' => env('RABBITMQ_EXCHANGE_DURABLE', true),
                        'is_auto_delete' => env('RABBITMQ_EXCHANGE_AUTO_DELETE', false),
                    ],
                    'queue' => [
                        'name' => env('RABBITMQ_QUEUE_NAME', 'email_queue'),
                        'is_passive' => env('RABBITMQ_QUEUE_PASSIVE', false),
                        'is_durable' => env('RABBITMQ_QUEUE_DURABLE', true),
                        'is_auto_delete' => env('RABBITMQ_QUEUE_AUTO_DELTE', false),
                    ]
                ],

                'transcription' => [
                    'exchange' => [
                        'name' => env('RABBITMQ_EXCHANGE_NAME', 'transcription_service'),
                        'type' => env('RABBITMQ_EXCHANGE_TYPE', 'direct'),
                        'is_passive' => env('RABBITMQ_EXCHANGE_PASSIVE', false),
                        'is_durable' => env('RABBITMQ_EXCHANGE_DURABLE', true),
                        'is_auto_delete' => env('RABBITMQ_EXCHANGE_AUTO_DELETE', false),
                    ],
                    'queue' => [
                        'name' => env('RABBITMQ_QUEUE_NAME', 'transcription_queue'),
                        'is_passive' => env('RABBITMQ_QUEUE_PASSIVE', false),
                        'is_durable' => env('RABBITMQ_QUEUE_DURABLE', true),
                        'is_auto_delete' => env('RABBITMQ_QUEUE_AUTO_DELTE', false),
                    ]
                ],
            ]
        ],
    ]
];
