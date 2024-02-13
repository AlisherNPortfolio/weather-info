<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    const BASE_URL = 'https://api.telegram.org/bot';

    const ACTION = 'sendMessage';

    const PARSE_MODE_HTML = 'HTML';

    private string $parsMode = self::PARSE_MODE_HTML;

    public function __construct(private readonly string $chat_id)
    {

    }

    public function setParseMode(string $mode): void
    {
        $this->parsMode = $mode;
    }

    public function getUrl(): string
    {
        $botId = config('weather.bot_id');

        return self::BASE_URL . $botId . '/' . self::ACTION;
    }

    public function sendMessage(string $message): bool|string
    {
        try {
            $url = $this->getUrl();
            $query = $this->buildQuery($message);
            $response = Http::get("{$url}?$query");

            if ($response->ok()) {
                return $response->body();
            } else {
                Log::info('Telegram error reason: ' . $response->reason());
            }
        } catch (\Exception $e) {
            Log::info('Error on sending message to telegram. Error: ' . $e->getMessage());
        }

        return  false;
    }

    private function buildQuery(string $message): string
    {
        $params = [
            'parse_mode' => $this->parsMode,
            'chat_id' => $this->chat_id,
            'text' => $message
        ];

        return http_build_query($params);
    }
}
