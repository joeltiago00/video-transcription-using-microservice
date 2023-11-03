<?php

namespace App\Enums;

enum MessageEnum
{
    case STORE_USER_EMAIL_CONFIRMATION;
    case TRANSCRIPTION_INFO;
    case TRANSCRIPTION_GENERATE;

    public function routingKey(): string
    {
        return match ($this) {
            self::STORE_USER_EMAIL_CONFIRMATION => 'upload_file:user_store',
            self::TRANSCRIPTION_INFO => 'upload_file:transcription_info',
            self::TRANSCRIPTION_GENERATE => 'upload_file:transcription_generate'
        };
    }

    public function type(): string
    {
        return match ($this) {
            self::STORE_USER_EMAIL_CONFIRMATION => 'email_confirmation',
            self::TRANSCRIPTION_INFO => 'email_transcription_info',
            self::TRANSCRIPTION_GENERATE => 'transcription_generate'
        };
    }
}
