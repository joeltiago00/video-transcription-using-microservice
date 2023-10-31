<?php

namespace Upload\Messaging;

use App\Enums\CacheEnum;
use Illuminate\Support\Facades\Cache;
use Upload\Messaging\Facades\Messaging;

class MessagePublishEmailHandler
{
    public static function handle(): void
    {
        $payloads = Cache::get(CacheEnum::EMAIL->key());

        if (!is_array(current($payloads))) {
            self::publish($payloads, $payloads['routing_key']);

            return;
        }


        foreach ($payloads as $payload) {
            self::publish($payload, $payload['routing_key']);
        }
    }

    private static function publish(array $payload, string $routingKey): void
    {
        Messaging::publish(json_encode($payload), $routingKey);
    }
}
