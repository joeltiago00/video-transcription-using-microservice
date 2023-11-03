<?php declare(strict_types=1);

namespace Upload\Messaging\Contracts;

use Closure;

interface IMessaging
{
    public function channel(string $channel = 'upload'): self;

    public function publish(string $message, string $routingKey = ''): void;

    public function consume(Closure $callback, string $consumerTag = '', bool $noAck = true, bool $noWait = false): void;
}
