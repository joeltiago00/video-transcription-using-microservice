<?php

namespace Upload\Messaging\Messengers\RabbitMQ\DTO;

class QueueConfig
{
    public function __construct(
        public readonly string $name,
        public readonly bool   $isPassive,
        public readonly bool   $isDurable,
        public readonly bool $isAutoDelete
    ) {
    }
}
