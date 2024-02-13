<?php

namespace App\Console\Commands;

use App\Weather\WeatherProviderFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Weather extends Command
{
    private array $availableChannels = [
        'console', 'telegram', 'mail',
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
    public function handle()
    {
        $provider = $this->argument('provider');
        $city = $this->argument('city');
        $channel = $this->option('channel');

        $providersList = $this->getProviders();

        if (!in_array(str_replace('-', '_', $provider), $providersList)) {
            $this->error("Unsupported provider {$provider}");

            return;
        }

        if (!in_array($channel, $this->availableChannels)) {
            $this->error("Unsupported channel option {$channel}");

            return;
        }

        $weatherProvider = WeatherProviderFactory::createService($provider);
        $temperature = $weatherProvider->getCurrentWeather($city);
        if (!$temperature) {
            $this->error("Can not get data from an API");
            return;
        }
dd($temperature);
        // ... handling with channels tomorrow, Xudo xohlasa!
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'provider' => ['Qaysi ob-havo provideridan foydalanmoqchisiz?', 'M: weather-api'],
            'city' => ["Qaysi shahar uchun ob-havo ma'lumotini olmoqchisiz?", 'M: Tashkent'],
        ];
    }

    private function getProviders()
    {
        $providersInConfig = config('weather.api_key');

        if ($providersInConfig && is_array($providersInConfig) && count($providersInConfig) > 0) {
            return array_map(function ($provider) {
                return Str::snake($provider);
            }, array_keys($providersInConfig));
        }

        return [];
    }
}
