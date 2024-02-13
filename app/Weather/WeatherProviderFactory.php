<?php

namespace App\Weather;

use App\Weather\Contracts\IWeatherProvider;
use Illuminate\Support\Str;

class WeatherProviderFactory
{
    public static function createProvider(string $provider): IWeatherProvider
    {
        $providerClassName = Str::studly($provider).'Provider';
        $providerClass = "App\\Weather\\Providers\\{$providerClassName}";

        abort_if(!class_exists($providerClass), 404, 'Class does not exist');

        return app($providerClass, ['providerName' => $provider]);
    }
}
