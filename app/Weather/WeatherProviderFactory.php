<?php

namespace App\Weather;

use App\Weather\Contracts\IWeatherProvider;
use Illuminate\Support\Str;

class WeatherProviderFactory
{
    public static function createService(string $provider): IWeatherProvider
    {
        $providerClassName = Str::camel($provider).'Provider';
        $providerClass = "App\\Weather\\Providers\\{$providerClassName}";

        abort_if(!class_exists($providerClass), 400, 'Class does not exist');

        return app($providerClass);
    }
}
