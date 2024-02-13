<?php

namespace App\Weather\Channels;
use App\Services\TelegramService;
use App\Weather\Contracts\IWeatherChannel;
use App\Weather\WeatherChannel;

class TelegramChannel extends WeatherChannel implements IWeatherChannel
{
    private string $telegramApi = "https://api.telegram.org/bot";

    private string $action = "sendMessage";
    public function demonstrate(float $temperature, string $city, string $channel = null): void
    {
        $today = date('d-m-Y');
        $message = "<b>Today's current temperature ({$today})</b>" . PHP_EOL .
                    "<b>City Name</b>: {$city}" . PHP_EOL .
                    "<b>Temperature</b>: {$temperature} °С";
        $response = app(TelegramService::class, ['chat_id' => $channel])->sendMessage($message);

        if (!$response) {
            $this->console->write("<error>Message could not be send to telegram</error>");
        } else {
            $this->console->write("<fg=white;bg=green>Message sent</>");
        }
    }
}
