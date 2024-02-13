<?php

namespace App\Weather\Providers;

use App\Weather\WeatherProvider;
use Illuminate\Http\Client\Response;

class WeatherApiProvider extends WeatherProvider
{
    protected function setApiKey(): void
    {
        $this->apiKey = config('weather.api_key.weather_api');
    }

    protected function setApi(): void
    {
        $this->api = "https://api.weatherapi.com/v1/current.json?key={$this->apiKey}&q={$this->location}&aqi=no";
    }

    protected function getData(Response $response): mixed
    {
        return $response->json('current')['temp_c'];
    }
}
