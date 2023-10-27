<?php

namespace Email\Messaging\Messengers\RabbitMQ\Actions;

use Closure;
use Email\Messaging\Factory\Factories\RabbitMQ\RabbitMQConnection;

class Consume
{
    public function __construct(private readonly RabbitMQConnection $connection)
    {
    }

    public function handle(Closure $callback, string $queue): mixed
    {
        $this->connection
            ->channel()
            ->basicConsume($callback, $queue);
    }
}
