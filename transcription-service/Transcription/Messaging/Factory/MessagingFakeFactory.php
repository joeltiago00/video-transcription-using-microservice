<?php declare(strict_types=1);

namespace Transcription\Messaging\Factory;

use Transcription\Messaging\Contracts\IMessaging;
use Transcription\Messaging\Exceptions\MessagingException;
use Transcription\Messaging\Factory\Factories\RabbitMQ\RabbitMQFactory;
use Transcription\Messaging\Factory\Factories\RabbitMQ\RabbitMQFakeFactory;

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
