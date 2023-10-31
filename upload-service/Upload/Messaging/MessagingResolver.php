<?php declare(strict_types=1);

namespace Upload\Messaging;

use Upload\Messaging\Contracts\IMessaging;
use Upload\Messaging\Factory\MessagingFactory;
use Upload\Messaging\Factory\MessagingFakeFactory;

class MessagingResolver
{
    public static function resolve(): IMessaging
    {
        $defaultService = config('messaging.default');

        if (Messaging::$isFake) {
            return MessagingFakeFactory::create($defaultService);
        }

        return MessagingFactory::create($defaultService);
    }
}
