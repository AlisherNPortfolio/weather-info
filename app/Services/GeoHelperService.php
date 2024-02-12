<?php

use Illuminate\Support\Facades\Http;

final class GeoHelperService
{
    private $api = "https://api.bigdatacloud.net/data/reverse-geocode-client";

    public string $lang = 'en';

    public function __construct(private float $latitude, private float $longitude)
    {}

    public function getPlaceByCoordinates()
    {
        $query = $this->getQuery();

        try {
            $response = Http::get("{$this->api}?{$query}");

            if ($response->ok()) {
                return $response->json("city");
            }
        } catch (Exception $e) {
        }

        return false;
    }

    private function getQuery()
    {
        $parameters = [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'localityLang' => $this->lang
        ];
        return http_build_query($parameters);
    }
}
