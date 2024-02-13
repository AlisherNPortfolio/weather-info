<?php

return [
    'api_key' => [
        'weather_api' => env('WEATHER_API_KEY'),
        'visual_crossing' => env('VISUAL_CROSSING_API_KEY'),
        'weather_bit' => env('WEATHERBIT_API_KEY'),
    ],
    'cache_time' => 600,
];
