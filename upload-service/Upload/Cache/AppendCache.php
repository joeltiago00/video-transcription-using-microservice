<?php

namespace Upload\Cache;

use Illuminate\Support\Facades\Cache;

class AppendCache
{
    public function handle(string $key, array $newValue): void
    {
        $defaultTtl = config('app.cache_ttl');

        if (!Cache::has($key)) {
            Cache::put($key, $newValue, $defaultTtl);

            return;
        }

        $value[] = Cache::get($key);
        $value[] = $newValue;

        Cache::put($key, $value, $defaultTtl);
    }
}
