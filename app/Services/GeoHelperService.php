<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class GeoHelperService
{
    private const API = "http://api.openweathermap.org/geo/1.0/direct?";

    private $api;

    public string $lang = 'en';

    public function __construct()
    {
        $this->api = self::API;
    }

    public function setBaseApiUser(): void
    {
        $this->api = self::API;
        $this->setApiKey();
    }

    private function setApiKey(): void
    {
        $apiKey = env('OPEN_WEATHER_MAP_API_KEY');
        $this->api .= "appid={$apiKey}";
    }

    public function setCoordinates(float $longitude, float $latitude): self
    {
        $this->setBaseApiUser();
        $this->api .= "&lat={$latitude}&lon={$longitude}&limit=1";

        return $this;
    }

    public  function  setCityName(string $city): self
    {
        $this->setBaseApiUser();
        $this->api .= "&q={$city}";

        return $this;
    }

    public function setLimit(int $limit = 1): self
    {
        $this->api .= "&limit={$limit}";

        return $this;
    }

    private function getApiResponse(): mixed
    {
        try {
            $response = Http::get($this->api);

            if ($response->ok()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::info("Error on getting response: " . $e->getMessage());
        }

        return false;
    }

    public function getPlaceByCoordinates(float $longitude, float $latitude)
    {
        $this->setCoordinates($longitude, $latitude)
            ->setLimit();

        return $this->getApiResponse();
    }

    public function getCoordinatesByCity(string $city)
    {
        $this->setCityName($city)
            ->setLimit();

        return $this->getApiResponse();
    }
}
