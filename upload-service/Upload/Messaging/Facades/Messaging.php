<?php declare(strict_types=1);

namespace Upload\Messaging\Facades;

use Upload\Messaging\Messaging as AbstractMessaging;
use Illuminate\Support\Facades\Facade;

/**
 * @method static channel(string $channel = 'upload'): IMessage
 * @method static publish(string $message, string $routingKey = ''): void
 * @method static consume(\Closure $callback, string $consumerTag = '', bool $noAck = true, bool $noWait = false): void
 * @method static fake(): void
 */
class Messaging extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AbstractMessaging::FACADE_ACCESSOR;
}
}
