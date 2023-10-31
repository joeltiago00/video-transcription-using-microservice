<?php declare(strict_types=1);

namespace Upload\Messaging\Factory;

use Upload\Messaging\Contracts\IMessaging;
use Upload\Messaging\Exceptions\MessagingException;
use Upload\Messaging\Factory\Factories\RabbitMQ\RabbitMQFactory;
use Upload\Messaging\Factory\Factories\RabbitMQ\RabbitMQFakeFactory;

class MessagingFakeFactory
{
    public static function create(string $messagingService): IMessaging
    {
        return match ($messagingService) {
            'rabbitmq' => RabbitMQFakeFactory::create(),
            default => throw MessagingException::serviceNotImplemented($messagingService)
        };
    }
}
