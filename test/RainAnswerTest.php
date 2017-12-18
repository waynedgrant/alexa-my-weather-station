<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class RainAnswerTest extends PHPUnit\Framework\TestCase
{
    public function test_no_rounding_daily_rainfall() {
        $testee = new RainAnswer($this->create_weather_json('5.00'));
        $this->assertSame(
            '<speak>Today\'s rain fall is 5 millimetres.</speak>',
            $testee->generate());
    }

    public function test_round_daily_rainfall_up() {
        $testee = new RainAnswer($this->create_weather_json('5.55'));
        $this->assertSame(
            '<speak>Today\'s rain fall is 6 millimetres.</speak>',
            $testee->generate());
    }

    public function test_round_daily_rainfall_down() {
        $testee = new RainAnswer($this->create_weather_json('5.50'));
        $this->assertSame(
            '<speak>Today\'s rain fall is 5 millimetres.</speak>',
            $testee->generate());
    }

    public function test_zero_mm_daily_rainfall() {
        $testee = new RainAnswer($this->create_weather_json('0.0'));
        $this->assertSame(
            '<speak>There has been no rain so far today.</speak>',
            $testee->generate());
    }

    public function test_one_mm_daily_rainfall() {
        $testee = new RainAnswer($this->create_weather_json('1.0'));
        $this->assertSame(
            '<speak>Today\'s rain fall is 1 millimetre.</speak>',
            $testee->generate());
    }

    public function test_missing_daily_rainfall() {
        $testee = new RainAnswer($this->create_weather_json(null));
        $this->assertSame(
            '<speak>The rain fall conditions are not known.</speak>',
            $testee->generate());
    }

    private function create_weather_json($daily_rainfall_mm) {
        return array(
            "weather" =>
                array('rainfall' =>
                    array(
                        'daily' => array('mm' => $daily_rainfall_mm))));
    }
}
?>
