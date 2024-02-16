<?php

namespace App\Weather\Providers;

use App\Weather\WeatherProvider;
use Illuminate\Http\Client\Response;

class VisualCrossingProvider extends WeatherProvider
{
    protected function setApiKey(): void
    {
        $this->apiKey = config('weather.api_key.visual_crossing');
    }

    protected function setApi(): void
    {
        $this->api = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{$this->location}?unitGroup=metric&include=current&key={$this->apiKey}&contentType=json";
    }

    protected function getData(array $response): mixed
    {
        return  $response['currentConditions']['temp'];
    }
}
