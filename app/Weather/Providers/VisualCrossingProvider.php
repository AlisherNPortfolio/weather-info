<?php

namespace App\Weather\Providers;

use App\Weather\WeatherProvider;

class VisualCrossingProvider extends WeatherProvider
{
    protected function setApiKey(): void
    {
        $this->apiKey = config('weather.api_key.visual_crossing');
    }

    protected function setApi(): void
    {
        $this->api = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Tashkent?unitGroup=metric&include=current&key={$this->apiKey}&contentType=json";
    }
}
