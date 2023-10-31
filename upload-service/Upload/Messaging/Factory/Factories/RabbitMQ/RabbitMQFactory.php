<?php declare(strict_types=1);

namespace Upload\Messaging\Factory\Factories\RabbitMQ;

use Upload\Messaging\Contracts\IMessaging;
use Upload\Messaging\Contracts\IMessagingFactory;
use Upload\Messaging\Messengers\RabbitMQ\RabbitMQ;

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
