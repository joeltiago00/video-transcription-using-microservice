<?php declare(strict_types=1);

namespace Email\Messaging\Messengers\RabbitMQ\Actions;

use Email\Messaging\Factory\Factories\RabbitMQ\RabbitMQConnection;

class Publish
{
    public function __construct(private readonly RabbitMQConnection $connection)
    {
    }

    public function handle(string $message, string $exchange, string $queue, string $routingKey): void
    {
        $this->connection
            ->channel()
            ->exchangeDeclare($exchange)
            ->queueDeclare($queue)
            ->queueBind($queue, $exchange, $routingKey)
            ->basicPublish($message, $exchange, $routingKey);
    }
}
