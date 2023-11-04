<?php declare(strict_types=1);

namespace Transcription\Messaging;

use Transcription\Messaging\Contracts\IMessagingFake;

abstract class Messaging implements IMessagingFake
{
    public static bool $isFake = false;

    public const FACADE_ACCESSOR = 'Messaging';

    public const DEFAULT_CHANNEL = 'transcription';

    public static function fake(): void
    {
        //TODO:: handle this on facade
        static::$isFake = true;
    }
}
