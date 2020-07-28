<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Services\AverageForecastTemp;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AverageTempTest extends TestCase
{
    /** @test */
    public function get_temp()
    {
        Http::fake([
            'api.weatherbit.io/*' => Http::response([
                'data' => [
                    ['temp' => 12],
                    ['temp' => 10],
                    ['temp' => 8],
                ],
            ]),
        ]);

        $temp = app(AverageForecastTemp::class);
        $avg = $temp->average(new Location('someCity', 'someCountry'));

        $this->assertEquals(10, $avg);
    }

    /** @test */
    public function cached_temp()
    {
        Http::fake([
            'api.weatherbit.io/*' => Http::response([
                'data' => [
                    ['temp' => 12],
                    ['temp' => 10],
                    ['temp' => 8],
                ],
            ]),
        ]);

        $temp = app(AverageForecastTemp::class);
        $temp->average(new Location('someCity', 'someCountry'));

        Cache::shouldReceive('remember')
                ->once()
                ->andReturn('22');

        $avg = $temp->average(new Location('someCity', 'someCountry'));
        $this->assertEquals(22, $avg);
    }
}