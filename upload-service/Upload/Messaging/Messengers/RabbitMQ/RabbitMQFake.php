<?php

namespace Upload\Messaging\Messengers\RabbitMQ;

use Closure;
use Upload\Messaging\Contracts\IMessaging;

class RabbitMQFake implements IMessaging
{

    public function channel(string $channel = 'upload'): IMessaging
    {
        return $this;
    }

    public function publish(string $message, string $routingKey = ''): void
    {
        return;
    }

    public function consume(Closure $callback, string $consumerTag = '', bool $noAck = true, bool $noWait = false): void
    {
        return;
    }
}
