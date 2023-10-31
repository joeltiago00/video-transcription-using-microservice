<?php declare(strict_types=1);

namespace Upload\Messaging\Contracts;

interface IMessagingFactory
{
    public static function create(): IMessaging;
}
