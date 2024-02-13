<?php

namespace App\Weather;

use App\Weather\Contracts\IWeatherChannel;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class WeatherChannel
{
    public function __construct(protected ConsoleOutput $console)
    {

    }
}
