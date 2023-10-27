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

    public function exchangeDeclare(string $exchange, string $type, bool $isPassive, bool $isDurable, bool $isAutoDelete): self
    {
        $this->channel->exchange_declare($exchange, $type, $isPassive, $isDurable, $isAutoDelete);

        return $this;
    }

    public function queueDeclare(string $queue, bool $isPassive, bool $isDurable, bool $isAutoDelete): self
    {
        $this->channel->queue_declare($queue, $isPassive, $isDurable, $isAutoDelete);

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

    public function basicConsume(Closure $callback, string $queue, string $consumerTag, bool $noAck, bool $noWait): void
    {
        $this->channel->basic_consume($queue, $consumerTag, false, $noAck, false, $noWait, $callback);

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
