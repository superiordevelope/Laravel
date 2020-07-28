<?php

namespace App\Services;

use App\Models\Forecast;

class TempCalculator
{
    /**
     * @param Forecast[] $forecast
     */
    public function average(array $forecast): float
    {
        $sum = 0;
        foreach ($forecast as $f) {
            $sum += $f->temperature;
        }
        return $sum / count($forecast);
    }
}