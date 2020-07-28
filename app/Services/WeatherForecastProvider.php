<?php

namespace App\Services;

use App\Models\Forecast;
use App\Models\Location;

/**
 * Generic forecast provider.
 */
interface WeatherForecastProvider
{
    /**
     * Retrieve weather forecast for the specified location.
     *
     * @return Forecast[]
     */
    public function forecast(Location $location, int $days = 10): array;
}
