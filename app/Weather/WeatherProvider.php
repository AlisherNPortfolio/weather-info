<?php

namespace App\Weather;

use App\Weather\Contracts\IWeatherProvider;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class WeatherProvider implements IWeatherProvider
{
    protected string $apiKey;

    protected string $api;

    protected string $location;

    final public function __construct(protected string $providerName)
    {

    }

    protected function getResponse()
    {
        $cacheTime = config('weather.cache_time');
        $cacheKey = "{$this->providerName}_{$this->location}";

        try {
            // TODO: object caching-ni redis-ga o'tkazish
            return Cache::remember($cacheKey, $cacheTime, function () use ($cacheKey) {
                $response = Http::get($this->api);

                if ($response->ok()) {
                    return $this->getData($response);
                } else {
                    Log::info($response->reason());
                    $this->clearCache($cacheKey);
                }

                return false;
            });
        } catch (Exception $e) {
            Log::info('Error on getting data from a weather API. ' . $e->getMessage());
            $this->clearCache($cacheKey);
        }

        return false;
    }

    protected function getData(Response $response): mixed
    {
        return $response->json();
    }

    public function getCurrentWeather(string $city): mixed
    {
        $this->location = $city;
        $this->setApiKey();
        $this->setApi();

        if (!$data = $this->getResponse()) {
            return false;
        }

        return $data;
    }

    private function clearCache(string $cacheKey): void
    {
        Cache::forget($cacheKey);
    }

    abstract protected function setApiKey(): void;

    abstract protected function setApi(): void;
}
