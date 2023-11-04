<?php

namespace Transcription\Messaging;

use App\Enums\CacheEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Transcription\Messaging\Facades\Messaging;

class MessagePublishEmailHandler
{
    static $a = 1;

    public static function handle(): void
    {
        $data = Cache::get(CacheEnum::EMAIL->key());

        collect($data)->groupBy('channel')
            ->each(fn($payloads, $channel) => self::processMessages($channel, $payloads));
    }

    private static function processMessages(string $channel, Collection $groupedPayloads): void
    {

        $groupedPayloads->each(function ($payloads) use ($channel) {
            self::publish(collect($payloads), $channel);
        });
    }

    private static function publish(Collection $payloads, string $channel): void
    {
        if (!is_array(current($payloads->toArray()))) {
            Messaging::channel(!empty($channel) ? $channel : self::getChannelInArray($payloads->toArray()))
                ->publish(json_encode($payloads), $payloads['routing_key']);

            return;
        }

        $payloads->each(function ($payload, $key) use ($channel) {
            if (is_string($payload)) dd($payload, $key);

            Messaging::channel(!empty($channel) ? $channel : self::getChannelInArray($payload))
                ->publish(json_encode($payload), $payload['routing_key']);
        });
    }

    private static function getChannelInArray(array $payload): string
    {
        return $payload['channel'];
    }
}
