<?php declare(strict_types=1);

namespace Transcription\Messaging\Messengers\RabbitMQ;

use Closure;
use Transcription\Messaging\Contracts\IMessaging;
use Transcription\Messaging\Factory\Factories\RabbitMQ\RabbitMQConnection;
use Transcription\Messaging\Messaging as AbstractMessaging;
use Transcription\Messaging\Messengers\RabbitMQ\Actions\Consume;
use Transcription\Messaging\Messengers\RabbitMQ\Actions\Publish;
use Transcription\Messaging\Messengers\RabbitMQ\DTO\ExchangeConfig;
use Transcription\Messaging\Messengers\RabbitMQ\DTO\QueueConfig;

class RabbitMQ extends AbstractMessaging implements IMessaging
{
    private string $channel = AbstractMessaging::DEFAULT_CHANNEL;
    private Publish $publish;
    private Consume $consume;

    public function __construct(
        private readonly RabbitMQConnection $connection,
    )
    {
        $this->publish = new Publish($this->connection);
        $this->consume = new Consume($this->connection);
    }

    public function channel(string $channel = 'transcription'): IMessaging
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
        $this->consume->handle($callback, $this->getConfigByKey('queue.name'), $consumerTag, $noAck, $noWait);
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

    private function getConfigByKey(string $key): mixed
    {
        return config(sprintf('messaging.connections.rabbitmq.channels.%s.%s', $this->channel, $key));
    }
}
