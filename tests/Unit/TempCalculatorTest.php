<?php

namespace Tests\Unit;

use App\Models\Forecast;
use App\Services\TempCalculator;
use Tests\TestCase;

class TempCalculatorTest extends TestCase
{
    /** @test */
    public function average_temp()
    {
        $data = [
            new Forecast(10),
            new Forecast(12),
            new Forecast(8),
        ];

        $calc = new TempCalculator();

        $this->assertEquals(10, $calc->average($data));
    }
}