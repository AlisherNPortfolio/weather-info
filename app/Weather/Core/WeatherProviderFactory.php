<?php

namespace App\Weather\Core;

use Illuminate\Support\Str;

class WeatherServiceFactory
{
    public static function createService(string $provider): IWeatherProvider
    {
        $serviceClassName = Str::camel($provider) . "Provider";
        $serviceClass = "App\\Weather\\Providers\\{$serviceClassName}";

        abort_if(!class_exists($serviceClass), 400, "Class does not exist");

        return app($serviceClass);

    }
}
