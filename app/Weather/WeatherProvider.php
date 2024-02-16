<?php

namespace App\Weather;

use App\Services\RedisCacheService;
use App\Weather\Contracts\IWeatherProvider;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class WeatherProvider implements IWeatherProvider
{
    protected string $apiKey;

    protected string $api;

    protected string $location;

    protected ConsoleOutput $consoleOutput;

    final public function __construct(protected string $providerName)
    {
        $this->consoleOutput = new ConsoleOutput();
    }

    protected function getResponse()
    {
        $cacheTime = config('weather.cache_time');
        $cacheKey = "{$this->providerName}_{$this->location}";

        try {
            [$response, $responseOk, $responseReason] = RedisCacheService::cacheHttpGet($cacheKey, $cacheTime, function () {
                return Http::get($this->api);
            });


            if ($responseOk) {
                return $this->getData($response);
            } else {
                $this->consoleOutput->write("<error>{$responseReason}</error>");
                $this->logOnError($responseReason, $cacheKey);
            }

        } catch (Exception $e) {
            $message = 'Error on getting data from a weather API. ' . $e->getMessage() . " " . $e->getLine() . " ". $e->getFile();
            $this->logOnError(
                $message,
                $cacheKey
            );
            $this->consoleOutput->write("<error>" . $message . "</error>");
        }

        return false;
    }

    protected function getData(array $response): mixed
    {
        return $response;
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

    protected function logOnError(string $errorMessage, string $cacheKey): void
    {
        Log::info('Error on getting data from a weather API. ' . $errorMessage);
        $this->clearCache($cacheKey);
    }

    abstract protected function setApiKey(): void;

    abstract protected function setApi(): void;
}
