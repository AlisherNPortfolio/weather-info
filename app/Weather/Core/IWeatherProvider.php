<?php

namespace App\Weather\Core;

interface IWeatherProvider
{
    public function getCurrentWeather(string $city): int;
}
