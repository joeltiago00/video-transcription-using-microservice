<?php declare(strict_types=1);

namespace Transcription\Messaging\Factory\Factories\RabbitMQ;

use Transcription\Messaging\Contracts\IMessaging;
use Transcription\Messaging\Contracts\IMessagingFactory;
use Transcription\Messaging\Messengers\RabbitMQ\RabbitMQ;
use Transcription\Messaging\Messengers\RabbitMQ\RabbitMQFake;

class RabbitMQFakeFactory implements IMessagingFactory
{

    public static function create(): IMessaging
    {
        return new RabbitMQFake();
    }
}
