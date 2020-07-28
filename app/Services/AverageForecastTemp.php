<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Support\Facades\Cache;

class AverageForecastTemp
{
    private WeatherForecastProvider $forecastProvider;
    private TempCalculator $tempCalculator;
    private int $expire;

    public function __construct(
        WeatherForecastProvider $forecastProvider,
        TempCalculator $tempCalculator,
        int $expire
    ) {
        $this->forecastProvider = $forecastProvider;
        $this->tempCalculator = $tempCalculator;
        $this->expire = $expire;
    }

    public function average(Location $location, int $days = 10): float
    {
        $cacheKey = $this->getCacheKey($location, $days);
        $expire = now()->addMinutes($this->expire);

        return Cache::remember($cacheKey, $expire, function () use ($location, $days) {
            return $this->fetch($location, $days);
        });
    }

    protected function getCacheKey(Location $location, int $days)
    {
        return $location->cityName .
               $location->countryCode .
               $days;
    }

    protected function fetch(Location $location, int $days)
    {
        return $this->tempCalculator->average(
            $this->forecastProvider->forecast($location, $days)
        );
    }
}