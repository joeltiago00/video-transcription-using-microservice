<?php declare(strict_types=1);

namespace Email\Messaging\Contracts;

use Closure;

interface IMessaging
{
    public function channel(string $channel = 'default'): self;

    public function publish(string $message, string $routingKey = ''): void;

    public function consume(Closure $callback, string $consumerTag = '', bool $noAck = true, bool $noWait = false): void;
}
