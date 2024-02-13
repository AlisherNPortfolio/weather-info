<?php

namespace App\Weather;

use App\Weather\Contracts\IWeatherChannel;
use Illuminate\Support\Str;

class WeatherChannelFactory
{
    public static function createChannel(string $channel): IWeatherChannel
    {
        $channelClassName = Str::camel($channel).'Channel';
        $channelClass = "App\\Weather\\Channels\\{$channelClassName}";

        abort_if(!class_exists($channelClass), 404, 'Class does not exist');

        return app($channelClass);
    }
}
