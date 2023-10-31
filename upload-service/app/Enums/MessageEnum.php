<?php

namespace App\Enums;

enum MessageEnum
{
    case STORE_USER_EMAIL_CONFIRMATION;
    case TRANSCRIPTION_INFO;

    public function routingKey(): string
    {
        return match ($this) {
            self::STORE_USER_EMAIL_CONFIRMATION => 'upload_file:user_store',
            self::TRANSCRIPTION_INFO => 'upload_file:transcription_info'
        };
    }

    public function type()
    {
        return match ($this) {
            self::STORE_USER_EMAIL_CONFIRMATION => 'email_confirmation',
            self::TRANSCRIPTION_INFO => 'email_transcription_info'
        };
    }
}
