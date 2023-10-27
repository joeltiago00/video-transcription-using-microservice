<?php declare(strict_types=1);

namespace Email\Messaging\Messengers\RabbitMQ\Actions;

use Email\Messaging\Factory\Factories\RabbitMQ\RabbitMQConnection;
use Email\Messaging\Messengers\RabbitMQ\DTO\ExchangeConfig;
use Email\Messaging\Messengers\RabbitMQ\DTO\QueueConfig;

class Publish
{
    public function __construct(private readonly RabbitMQConnection $connection)
    {
    }

    public function handle(string $message, string $routingKey, ExchangeConfig $exchangeConfig, QueueConfig $queueConfig): void
    {
        $exchangeName = $exchangeConfig->name;
        $queueName = $queueConfig->name;
        $this->connection
            ->channel()
            ->exchangeDeclare(
                $exchangeName,
                $exchangeConfig->type,
                $exchangeConfig->isPassive,
                $exchangeConfig->isDurable,
                $exchangeConfig->isAutoDelete
            )
            ->queueDeclare(
                $queueName,
                $queueConfig->isPassive,
                $queueConfig->isDurable,
                $queueConfig->isAutoDelete
            )
            ->queueBind($queueName, $exchangeName, $routingKey)
            ->basicPublish($message, $exchangeName, $routingKey);
    }
}
