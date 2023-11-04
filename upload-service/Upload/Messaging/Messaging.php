<?php declare(strict_types=1);

namespace Upload\Messaging;

use Upload\Messaging\Contracts\IMessagingFake;

abstract class Messaging implements IMessagingFake
{
    public static bool $isFake = false;

    public const FACADE_ACCESSOR = 'Messaging';


    public const DEFAULT_CHANNEL = 'upload';

    public static function fake(): void
    {
        //TODO:: handle this on facade
        static::$isFake = true;
    }
}
