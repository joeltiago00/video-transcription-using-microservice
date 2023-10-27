<?php declare(strict_types=1);

namespace Email\Messaging\Factory\Factories\RabbitMQ;

use Email\Messaging\Contracts\IMessaging;
use Email\Messaging\Contracts\IMessagingFactory;
use Email\Messaging\Messengers\RabbitMQ\RabbitMQ;

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
