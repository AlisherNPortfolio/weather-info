<?php

namespace App\Weather;

use App\Weather\Contracts\IWeatherProvider;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class WeatherProvider implements IWeatherProvider
{
    protected string $apiKey;

    protected string $api;

    protected string $location;

    protected function getResponse()
    {
        try {
            $cacheTime = config('weather.cache_time');
            $response = Cache::remember('weather_api_'.$this->apiKey, $cacheTime, function () {
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

    public function getCurrentWeather(string $city): mixed
    {
        $this->location = $city;
        $this->setApiKey();
        $this->setApi();

        if (!$data = $this->getResponse()) {
            throw new Exception('Can not get response from an API');
        }

        return $data;
    }

    abstract protected function setApiKey(): void;

    abstract protected function setApi(): void;
}
