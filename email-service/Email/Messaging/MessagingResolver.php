<?php

namespace Email\Messaging;

use Email\Messaging\Contracts\IMessaging;
use Email\Messaging\Factory\MessagingFactory;

class MessagingResolver
{
    public static function resolve(): IMessaging
    {
        return MessagingFactory::create(config('messaging.default'));
    }
}
