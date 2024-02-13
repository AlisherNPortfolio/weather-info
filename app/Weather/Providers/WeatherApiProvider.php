<?php

namespace App\Weather\Providers;

use App\Weather\WeatherProvider;

class WeatherApiProvider extends WeatherProvider
{
    protected function setApiKey(): void
    {
        $this->apiKey = config('weather.api_key.weather_api');
    }

    protected function setApi(): void
    {
        $this->api = "https://api.weatherapi.com/v1/current.json?key={$this->apiKey}&q=Tashkent&aqi=no";
    }
}
