<?php

namespace App\Models;

class Forecast
{
    public int $temperature;

    public function __construct(int $temp = 0)
    {
        $this->temperature = $temp;
    }
}