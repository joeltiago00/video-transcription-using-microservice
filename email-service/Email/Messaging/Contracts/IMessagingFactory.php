<?php

namespace Email\Messaging\Contracts;

interface IMessagingFactory
{
    public static function create(): IMessaging;
}
