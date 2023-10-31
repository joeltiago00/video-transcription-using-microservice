<?php

namespace App\Enums;

enum CacheEnum
{
    case EMAIL;

    public function key(): string
    {
        return match ($this) {
            self::EMAIL => 'payload_emails'
        };
    }
}
