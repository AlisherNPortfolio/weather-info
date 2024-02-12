<?php

namespace App\Weather\Core;

class WeatherChannel implements IWeatherChannel
{
    public function __construct(private IWeatherChannel $channel)
    {

    }

    public function demonstrate(): void
    {
        return $this->channel->demonstrate();
    }
}
