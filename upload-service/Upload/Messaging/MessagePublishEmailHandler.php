<?php

namespace Upload\Messaging;

use App\Enums\CacheEnum;
use Illuminate\Support\Facades\Cache;
use Upload\Messaging\Facades\Messaging;

class MessagePublishEmailHandler
{
    public static function handle(): void
    {
        $data = Cache::get(CacheEnum::EMAIL->key());

        collect($data)->groupBy('channel')
            ->each(fn ($payloads, $channel) => self::publish($channel, $payloads->toArray()));
    }

    private static function publish(string $channel, array $payloads): void
    {
        collect($payloads)->each(function ($payload) use ($channel) {
            Messaging::channel($channel)->publish(json_encode($payload), $payload['routing_key']);
        });
    }
}
