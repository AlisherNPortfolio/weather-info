<?php

namespace App\Weather;

use App\Weather\Contracts\IWeatherChannel;
use Symfony\Component\Console\Output\ConsoleOutput;

abstract class WeatherChannel
{
    protected static $channelName;
    public function __construct(protected ConsoleOutput $console)
    {

    }

    protected function hasChannelValue(string|null $value): bool
    {
        if (!$value) {
            $this->console->write("<error>" . static::$channelName . " Channel value is not available!</error>");
            return false;
        }

        return true;
    }
}
