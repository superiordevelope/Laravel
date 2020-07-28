<?php

namespace App\Services;

use App\Exceptions\WeatherProviderException;
use App\Models\Forecast;
use App\Models\Location;
use Illuminate\Support\Facades\Http;

class WeatherBitProvider implements WeatherForecastProvider
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @inheritdoc
     */
    public function forecast(Location $location, int $days = 10): array
    {
        $response = $this->getResponse($location, $days);
        if ($response->status() != 200) {
            throw new WeatherProviderException('WeatherBit api error.', $response->status());
        }

        $json = $response->json();
        if (! isset($json['data'])) {
            throw new WeatherProviderException('Invalid json response.');
        }

        return $this->dataToModels($json['data']);
    }

    protected function getResponse(Location $location, int $days)
    {
        $params = [
            'key' => $this->apiKey,
            'city' => $location->cityName,
            'country' => $location->countryCode,
            'days' => $days,
        ];
        return Http::get('https://api.weatherbit.io/v2.0/forecast/daily', $params);
    }

    protected function dataToModels(array $responseData): array
    {
        $models = [];

        foreach ($responseData as $data) {
            $forecast = new Forecast();
            $forecast->temperature = $data['temp'];
            $models[] = $forecast;
        }

        return $models;
    }
}