<?php

namespace App\Weather\Providers;

use App\Services\GeoHelperService;
use App\Weather\WeatherProvider;
use Illuminate\Http\Client\Response;

class WeatherBitProvider extends WeatherProvider
{
    protected function setApiKey(): void
    {
        $this->apiKey = config('weather.api_key.weather_bit');
    }

    protected function setApi(): void
    {
        $location = app(GeoHelperService::class)->getCoordinatesByCity($this->location);
        $lat = $location[0]['lat'];
        $lon = $location[0]['lon'];

        $this->api = "https://api.weatherbit.io/v2.0/current?lat={$lat}&lon={$lon}&key={$this->apiKey}";
    }

    protected function getData(Response $response): mixed
    {
        $data = $response->json('data');

        return $data[0]['temp'];
    }
}
