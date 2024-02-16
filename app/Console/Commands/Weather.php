<?php

namespace App\Console\Commands;

use App\Weather\WeatherChannelFactory;
use App\Weather\WeatherProviderFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Exception\RunCommandFailedException;

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
    protected $signature = 'weather {provider?} {city?} {--channel=console}';

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
        $providersList = $this->getProviders();
        $provider = $this->argument('provider') ?? $this->choice("You didn't give provider name. Choose one of the following provider list", $providersList);
        $city = $this->argument('city') ?? $this->ask("Which city's weather do you want to know? Write city name");
        $channel = $this->option('channel');

        try {
            if (!in_array($provider, $providersList)) {
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
        } catch (\Exception | \Error $e) {
            $this->error("Unexpected exception: " . $e->getMessage());
        }
    }

    private function getProviders(): array
    {
        $providersInConfig = config('weather.api_key');

        if ($providersInConfig && is_array($providersInConfig) && count($providersInConfig) > 0) {
            return array_map(function ($provider) {
                return str_replace('_', '-', $provider);
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
