<?php declare(strict_types=1);

namespace Email\Messaging\Facades;

use Email\Messaging\MessagingConfig;
use Illuminate\Support\Facades\Facade;

/**
 * @method static channel(string $channel = 'default'): IMessage
 * @method static publish(string $message, string $routingKey = ''): void
 * @method static consume(\Closure $callback, string $consumerTag = '', bool $noAck = true, bool $noWait = false): mixed
 */
class Messaging extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MessagingConfig::FACADE_ACCESSOR;
}
}
