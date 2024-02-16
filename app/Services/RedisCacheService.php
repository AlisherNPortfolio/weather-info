<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class RedisCacheService
{
    public static function cacheHttpGet(string $key, int $ttl, callable $callback): array
    {
        $response = unserialize(Redis::hget($key, 'data'));
        $responseOk = Redis::hget($key, 'status');
        $responseReason = Redis::hget($key, 'reason');

        if (!$response) {
            $response = $callback();
            $responseOk = $response->ok();
            $responseReason = $response->reason();
            $response = $response->ok() ? $response->json() : null;

            Redis::hmset($key, ['data' => serialize($response), 'status' => $responseOk, 'reason' => $responseReason]);
            Redis::expire($key, $ttl);
        }

        return [$response, $responseOk, $responseReason];
    }
}
