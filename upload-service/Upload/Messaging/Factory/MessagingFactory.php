<?php declare(strict_types=1);

namespace Email\Messaging\Factory;

use Email\Messaging\Contracts\IMessaging;
use Email\Messaging\Exceptions\MessagingException;
use Email\Messaging\Factory\Factories\RabbitMQ\RabbitMQFactory;

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
