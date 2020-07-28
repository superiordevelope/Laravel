<?php

namespace App\Providers;

use App\Services\AverageForecastTemp;
use App\Services\TempCalculator;
use App\Services\WeatherBitProvider;
use App\Services\WeatherForecastProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WeatherForecastProvider::class, function ($app) {
            return new WeatherBitProvider(config('weather.weatherBit.apiKey'));
        });
        $this->app->bind(AverageForecastTemp::class, function ($app) {
            return new AverageForecastTemp(
                $app->make(WeatherForecastProvider::class),
                $app->make(TempCalculator::class),
                config('weather.expire')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
