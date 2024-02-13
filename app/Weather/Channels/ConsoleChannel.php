<?php

namespace App\Weather\Channels;
use App\Weather\Contracts\IWeatherChannel;
use App\Weather\WeatherChannel;
use Symfony\Component\Console\Output\ConsoleOutput;

class ConsoleChannel extends WeatherChannel implements IWeatherChannel
{
    public function demonstrate(float $temperature, string $city, string $channel = null): void
    {
        $this->console->writeln("<fg=white;bg=green>The temperature is {$temperature}°С in {$city}</>");
    }
}
