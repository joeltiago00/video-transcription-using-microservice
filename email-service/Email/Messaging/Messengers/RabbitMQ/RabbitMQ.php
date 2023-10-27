<?php declare(strict_types=1);

namespace Email\Messaging\Messengers\RabbitMQ;

use Closure;
use Email\Messaging\Contracts\IMessaging;
use Email\Messaging\Factory\Factories\RabbitMQ\RabbitMQConnection;
use Email\Messaging\MessagingConfig;
use Email\Messaging\Messengers\RabbitMQ\Actions\Consume;
use Email\Messaging\Messengers\RabbitMQ\Actions\Publish;

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
            $this->getConfigByKey('exchange'),
            $this->getConfigByKey('queue'),
            $routingKey,
        );
    }

    public function consume(Closure $callback): mixed
    {
        return $this->consume->handle($callback, $this->getConfigByKey('queue'));
    }

    private function getConfigByKey(string $key): string
    {
        return $this->configChannels[$this->channel][$key];
    }
}
