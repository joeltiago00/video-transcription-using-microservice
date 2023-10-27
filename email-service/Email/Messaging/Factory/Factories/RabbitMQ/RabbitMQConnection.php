<?php declare(strict_types=1);

namespace Email\Messaging\Factory\Factories\RabbitMQ;

use Closure;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQConnection
{
    private \PhpAmqpLib\Channel\AMQPChannel|\PhpAmqpLib\Channel\AbstractChannel $channel;

    public function __construct(private readonly AMQPStreamConnection $connection)
    {
    }

    public function channel(): self
    {
        $this->channel = $this->connection->channel();

        return $this;
    }

    public function exchangeDeclare(string $exchange): self
    {
        $this->channel->exchange_declare($exchange, 'direct', false, true, false);

        return $this;
    }

    public function queueDeclare(string $queue): self
    {
        $this->channel->queue_declare($queue, false, true, false, false);

        return $this;
    }

    public function queueBind(string $queue, string $exchange, string $routingKey): self
    {
        $this->channel->queue_bind($queue, $exchange, $routingKey);

        return $this;
    }

    public function basicPublish(string $message, string $exchange, string $routingKey): void
    {
        $this->channel->basic_publish(new AMQPMessage($message), $exchange, $routingKey);

        $this->endConnection();
    }

    public function basicConsume(Closure $callback, string $queue): void
    {
        $this->channel->basic_consume($queue, '', false, true, false, false, $callback);

        do {
            $this->channel->wait();
        } while ($this->channel->is_consuming());

        $this->endConnection();
    }

    private function endConnection(): void
    {
        $this->channel->close();
        $this->connection->close();
    }

}
