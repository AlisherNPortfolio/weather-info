<?php

namespace App\Console\Commands;

use App\Weather\WeatherChannelFactory;
use App\Weather\WeatherProviderFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Weather extends Command
{
    private array $availableChannels = [
        'console', 'telegram', 'email',
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather {provider} {city} {--channel=console}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get weather information by a city';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $provider = $this->argument('provider');
        $city = $this->argument('city');
        $channel = $this->option('channel');

        $providersList = $this->getProviders();

        if (!in_array(str_replace('-', '_', $provider), $providersList)) {
            $this->error("Unsupported provider {$provider}");

            return;
        }

        [$channelName, $channelValue] = $this->getChannelData($channel);

        if (!in_array($channelName, $this->availableChannels)) {
            $this->error("Unsupported channel option {$channelName}");

            return;
        }

        $weatherProvider = WeatherProviderFactory::createProvider($provider);
        $temperature = $weatherProvider->getCurrentWeather($city);

        if (!$temperature) {
            $this->error("Can not get data from an API");
            return;
        }

        $weatherChannel = WeatherChannelFactory::createChannel($channelName);
        $weatherChannel->demonstrate($temperature, $city, $channelValue);
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'provider' => ['Qaysi ob-havo provideridan foydalanmoqchisiz?', 'M: weather-api'],
            'city' => ["Qaysi shahar uchun ob-havo ma'lumotini olmoqchisiz?", 'M: Tashkent'],
        ];
    }

    private function getProviders(): array
    {
        $providersInConfig = config('weather.api_key');

        if ($providersInConfig && is_array($providersInConfig) && count($providersInConfig) > 0) {
            return array_map(function ($provider) {
                return Str::snake($provider);
            }, array_keys($providersInConfig));
        }

        return [];
    }

    private function getChannelData(string $channel): array
    {
        $channel = explode(":", $channel);
        $channelName = $channel[0];
        $channelValue = null;

        if (isset($channel[1])) {
            $channelValue = $channel[1];
        }

        return [$channelName, $channelValue];
    }
}
