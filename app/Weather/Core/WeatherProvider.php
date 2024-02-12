<?php

namespace App\Weather\Core;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class WeatherProvider implements IWeatherProvider
{
    protected string $apiKey;

    protected string $api;

    public function __construct()
    {
        $this->setApiKey();
        $this->setApi();
    }

    protected function getResponse()
    {
        try {
            $response = Cache::remember('weather_api_' . $this->apiKey, 600, function () {
                return Http::get($this->api);
            });

            if ($response->ok()) {
                return $this->getData($response);
            }
        } catch (Exception $e) {
            Log::error('Error on getting data from a weather API');
        }

        return false;
    }

    protected function getData(Response $response): mixed
    {
        return $response->json();
    }

    public function getCurrentWeather(string $city): int
    {
        if (!$data = $this->getResponse()) {

        }
        return 1;
    }

    abstract protected function setApiKey(): void;

    abstract protected function setApi(): void;
}
