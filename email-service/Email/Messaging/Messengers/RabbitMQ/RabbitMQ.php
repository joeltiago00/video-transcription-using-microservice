<?php declare(strict_types=1);

namespace Email\Messaging\Messengers\RabbitMQ;

use Closure;
use Email\Messaging\Contracts\IMessaging;
use Email\Messaging\Factory\Factories\RabbitMQ\RabbitMQConnection;
use Email\Messaging\MessagingConfig;
use Email\Messaging\Messengers\RabbitMQ\Actions\Consume;
use Email\Messaging\Messengers\RabbitMQ\Actions\Publish;
use Email\Messaging\Messengers\RabbitMQ\DTO\ExchangeConfig;
use Email\Messaging\Messengers\RabbitMQ\DTO\QueueConfig;

class RabbitMQ implements IMessaging
{
    private array $configChannels;
    private string $channel = MessagingConfig::DEFAULT_CHANNEL;
    private Publish $publish;
    private Consume $consume;

    public function __construct(
        private readonly RabbitMQConnection $connection,
    )
    {
        $this->configChannels = config('messaging.connections.rabbitmq.channels');
        $this->publish = new Publish($this->connection);
        $this->consume = new Consume($this->connection);
    }

    public function channel(string $channel = 'default'): IMessaging
    {
        $this->channel = $channel;

        return $this;
    }

    public function publish(string $message, string $routingKey = ''): void
    {

        $this->publish->handle(
            $message,
            $routingKey,
            $this->getExchangeConfig(),
            $this->getQueueConfig()
        );
    }

    public function consume(Closure $callback, string $consumerTag = '', bool $noAck = true, bool $noWait = false): void
    {
        $this->consume->handle($callback, $this->getConfigByKey('queue'), $consumerTag, $noAck, $noWait);
    }

    private function getExchangeConfig(): ExchangeConfig
    {
        return new ExchangeConfig(
            $this->getConfigByKey('exchange.name'),
            $this->getConfigByKey('exchange.type'),
            (bool)$this->getConfigByKey('exchange.is_passive'),
            (bool)$this->getConfigByKey('exchange.is_durable'),
            (bool)$this->getConfigByKey('exchange.is_auto_delete'),
        );
    }

    private function getQueueConfig(): QueueConfig
    {
        return new QueueConfig(
            $this->getConfigByKey('queue.name'),
            (bool)$this->getConfigByKey('queue.is_passive'),
            (bool)$this->getConfigByKey('queue.is_durable'),
            (bool)$this->getConfigByKey('queue.is_auto_delete'),
        );
    }

    private function getConfigByKey(string $key): string
    {
        return $this->configChannels[$this->channel][$key];
    }
}
