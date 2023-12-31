<?php declare(strict_types=1);

namespace Upload\Messaging\Factory;

use Upload\Messaging\Contracts\IMessaging;
use Upload\Messaging\Exceptions\MessagingException;
use Upload\Messaging\Factory\Factories\RabbitMQ\RabbitMQFactory;

class MessagingFactory
{
    public static function create(string $messagingService): IMessaging
    {
        return match ($messagingService) {
            'rabbitmq' => RabbitMQFactory::create(),
            default => throw MessagingException::serviceNotImplemented($messagingService)
        };
    }
}
