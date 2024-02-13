<?php

namespace App\Weather\Channels;

use App\Mail\WeatherMail;
use App\Weather\Contracts\IWeatherChannel;
use App\Weather\WeatherChannel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailChannel extends WeatherChannel implements IWeatherChannel
{
    public function demonstrate(float $temperature, string $city, string $channel = null): void
    {
        $weatherData = [
            'temperature' => $temperature,
            'city' => $city
        ];

        if (Mail::to($channel)->send(new WeatherMail($weatherData))) {
            $this->console->write("<fg=white;bg=green>Email sent</>");
        } else {
            $this->console->write("<error>Email could not be sent!</error>");
        }

    }
}
