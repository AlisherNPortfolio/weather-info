<?php

namespace App\Weather\Channels;

use App\Jobs\SendWeatherToEmail;
use App\Weather\Contracts\IWeatherChannel;
use App\Weather\WeatherChannel;
use Illuminate\Support\Facades\Log;

class EmailChannel extends WeatherChannel implements IWeatherChannel
{
    protected static $channelName = "Email";

    public function demonstrate(float $temperature, string $city, string $channel = null): void
    {
        if (!$this->hasChannelValue($channel)) {
            return;
        }

        $weatherData = [
            'temperature' => $temperature,
            'city' => $city
        ];

        try {
            SendWeatherToEmail::dispatch($weatherData, $channel);
            $this->console->write("<fg=white;bg=green>Email sent</>");
        } catch (\Exception $e) {
            $this->console->write("<error>Email could not be sent!</error>");
            Log::info('Error on sending to email: ' . $e->getMessage());
        }
    }
}
