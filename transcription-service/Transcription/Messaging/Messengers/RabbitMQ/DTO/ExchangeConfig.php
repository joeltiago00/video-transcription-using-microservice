<?php

namespace Transcription\Messaging\Messengers\RabbitMQ\DTO;

class ExchangeConfig
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly bool   $isPassive,
        public readonly bool   $isDurable,
        public readonly bool $isAutoDelete
    ) {
    }
}
