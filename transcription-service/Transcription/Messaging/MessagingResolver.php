<?php declare(strict_types=1);

namespace Transcription\Messaging;

use Transcription\Messaging\Contracts\IMessaging;
use Transcription\Messaging\Factory\MessagingFactory;
use Transcription\Messaging\Factory\MessagingFakeFactory;

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
