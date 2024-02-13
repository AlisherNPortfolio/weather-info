<?php

namespace App\Weather;

use App\Weather\Contracts\IWeatherChannel;

class WeatherChannel implements IWeatherChannel
{
    public function __construct(private IWeatherChannel $channel)
    {

    }

    public function demonstrate(): void
    {
        $this->channel->demonstrate();
    }
}
