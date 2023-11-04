<?php declare(strict_types=1);

namespace Transcription\Messaging\Factory\Factories\RabbitMQ;

use Transcription\Messaging\Contracts\IMessaging;
use Transcription\Messaging\Contracts\IMessagingFactory;
use Transcription\Messaging\Messengers\RabbitMQ\RabbitMQ;

class RabbitMQFactory implements IMessagingFactory
{

    public static function create(): IMessaging
    {
        $dataConnect = config('messaging.connections.rabbitmq');

        return new RabbitMQ(
            RabbitMQConnector::get(
                $dataConnect['host'],
                $dataConnect['port'],
                $dataConnect['user'],
                $dataConnect['password'],
                $dataConnect['vhost'],
            )
        );
    }
}
