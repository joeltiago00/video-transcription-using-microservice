<?php declare(strict_types=1);

namespace Transcription\Messaging\Facades;

use Transcription\Messaging\Messaging as AbstractMessaging;
use Illuminate\Support\Facades\Facade;

/**
 * @method static channel(string $channel = 'transcription'): IMessage
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
