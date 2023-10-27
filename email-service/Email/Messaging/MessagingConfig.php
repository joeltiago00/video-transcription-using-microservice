<?php declare(strict_types=1);

namespace Email\Messaging;

abstract class MessagingConfig
{
    public const FACADE_ACCESSOR = 'Messaging';

    public const DEFAULT_CHANNEL = 'default';
}
