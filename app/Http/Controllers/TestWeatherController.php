<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestWeatherController extends Controller
{
    public function __construct(private Http $http)
    {

    }
    public function weatherApi(Request $request)
    {
        $apiKey = config('weather.api_key.weather_api');
        $api = "https://api.weatherapi.com/v1/current.json?key={$apiKey}&q=Tashkent&aqi=no";

        $response = Http::get($api);

        if ($response->ok()) {
            return $response->json();
        }

        return response()->json(false);

    }

    public function visualCrossing(Request $request)
    {
        $apiKey = config('weather.api_key.visual_crossing');
        $api = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/Tashkent?unitGroup=metric&include=current&key={$apiKey}&contentType=json";

        $response = Http::get($api);

        if ($response->ok()) {
            return $response->json();
        }

        return response()->json(false);
    }

    public function openMeteo(Request $request)
    {
    }

    public function weatherBit(Request $request)
    {
        $apiKey = config('weather.api_key.weather_bit');
        $api = "https://api.weatherbit.io/v2.0/current?lat=41.30091891764298&lon=69.25333619864107&key={$apiKey}&include=hourly";

        $response = Http::get($api);

        if ($response->ok()) {
            return $response->object()->data[0]->temp;
        }

        return response()->json(false);
    }
}
