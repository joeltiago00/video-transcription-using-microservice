<?php declare(strict_types=1);

namespace Transcription\Messaging\Contracts;

interface IMessagingFactory
{
    public static function create(): IMessaging;
}
