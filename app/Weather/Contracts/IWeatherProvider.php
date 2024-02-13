<?php

namespace App\Weather\Contracts;

interface IWeatherProvider
{
    public function getCurrentWeather(string $city): mixed;
}
