<?php declare(strict_types=1);

namespace Transcription\Messaging\Factory;

use Transcription\Messaging\Contracts\IMessaging;
use Transcription\Messaging\Exceptions\MessagingException;
use Transcription\Messaging\Factory\Factories\RabbitMQ\RabbitMQFactory;

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
