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

    protected function getData(array $response): mixed
    {
        return $response['current']['temp_c'];
    }
}
