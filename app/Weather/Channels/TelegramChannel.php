<?php

namespace App\Weather\Channels;
use App\Jobs\SendWeatherToTelegram;
use App\Weather\Contracts\IWeatherChannel;
use App\Weather\WeatherChannel;
use Illuminate\Support\Facades\Log;

class TelegramChannel extends WeatherChannel implements IWeatherChannel
{
    protected static $channelName = "Telegram";
    private string $telegramApi = "https://api.telegram.org/bot";

    private string $action = "sendMessage";
    public function demonstrate(float $temperature, string $city, string $channel = null): void
    {
        if (!$this->hasChannelValue($channel)) {
            return;
        }

        $today = date('d-m-Y');
        $message = "<b>Today's current temperature ({$today})</b>" . PHP_EOL .
                    "<b>City Name</b>: {$city}" . PHP_EOL .
                    "<b>Temperature</b>: {$temperature} °С";

        try {
            SendWeatherToTelegram::dispatch($message, $channel);
            $this->console->write("<fg=white;bg=green>Message sent</>");
        } catch (\Exception $e) {
            $this->console->write("<error>Message could not be send to telegram</error>");
            Log::info('Error on sending to telegram: ' . $e->getMessage());
        }
    }
}
