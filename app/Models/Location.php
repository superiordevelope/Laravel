<?php

namespace App\Models;

class Location
{
    public string $cityName;
    public string $countryCode;

    public function __construct(string $cityName, string $countryCode = '')
    {
        $this->cityName = $cityName;
        $this->countryCode = $countryCode;
    }
}