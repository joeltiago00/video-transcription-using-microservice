<?php declare(strict_types=1);

namespace Upload\Messaging\Factory\Factories\RabbitMQ;

use Upload\Messaging\Contracts\IMessaging;
use Upload\Messaging\Contracts\IMessagingFactory;
use Upload\Messaging\Messengers\RabbitMQ\RabbitMQ;
use Upload\Messaging\Messengers\RabbitMQ\RabbitMQFake;

class RabbitMQFakeFactory implements IMessagingFactory
{

    public static function create(): IMessaging
    {
        return new RabbitMQFake();
    }
}
