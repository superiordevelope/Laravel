<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\AverageForecastTemp;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WeatherController extends Controller
{
    public function forecast(Request $request, AverageForecastTemp $avgTemp)
    {
        $request->validate([
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $location = new Location(
            $request->city,
            $request->country
        );

        try {
            $temp = $avgTemp->average($location, 10);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }

        return [
            'temp' => $temp,
        ];
    }
}
