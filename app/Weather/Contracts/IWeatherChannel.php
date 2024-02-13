<?php

namespace App\Weather\Contracts;

interface IWeatherChannel
{
    public function demonstrate(float $temperature, string $city, string $channel = null): void;
}
