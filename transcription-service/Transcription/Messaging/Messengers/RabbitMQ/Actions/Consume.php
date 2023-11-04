<?php declare(strict_types=1);

namespace Transcription\Messaging\Messengers\RabbitMQ\Actions;

use Closure;
use Transcription\Messaging\Factory\Factories\RabbitMQ\RabbitMQConnection;

class Consume
{
    public function __construct(private readonly RabbitMQConnection $connection)
    {
    }

    public function handle(Closure $callback, string $queue, string $consumerTag, bool $noAck, bool $noWait): void
    {
        $this->connection
            ->channel()
            ->basicConsume($callback, $queue, $consumerTag, $noAck, $noWait);
    }
}
