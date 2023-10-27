<?php declare(strict_types=1);

namespace Email\Messaging\Contracts;

interface IMessagingFactory
{
    public static function create(): IMessaging;
}
