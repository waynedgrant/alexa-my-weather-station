<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class PressureAnswerTest extends PHPUnit_Framework_TestCase
{
    public function test_no_rounding_pressure_and_holding_steady() {
        $testee = new PressureAnswer($this->create_weather_json('1005.0', '0'));
        $this->assertSame(
            '<speak>The pressure is 1005 millibars.<break time="1s"/>The pressure is holding steady.</speak>',
            $testee->generate());
    }

    public function test_round_pressure_up_and_trending_up() {
        $testee = new PressureAnswer($this->create_weather_json('1005.6', '1'));
        $this->assertSame(
            '<speak>The pressure is 1006 millibars.<break time="1s"/>The pressure is trending up.</speak>',
            $testee->generate());
    }

    public function test_round_pressure_down_and_trending_down() {
        $testee = new PressureAnswer($this->create_weather_json('1005.5', '-1'));
        $this->assertSame(
            '<speak>The pressure is 1005 millibars.<break time="1s"/>The pressure is trending down.</speak>',
            $testee->generate());
    }

    public function test_missing_pressure() {
        $testee = new PressureAnswer($this->create_weather_json(null, '0'));
        $this->assertSame(
            '<speak>The pressure is not known.</speak>',
            $testee->generate());
    }

    public function test_missing_trend() {
        $testee = new PressureAnswer($this->create_weather_json('1005.0', null));
        $this->assertSame(
            '<speak>The pressure is not known.</speak>',
            $testee->generate());
    }

    private function create_weather_json($pressure_mb, $trend) {
        return array(
            "weather" =>
                array('pressure' =>
                    array(
                        'current' => array('mb' => $pressure_mb),
                        'trend' => $trend)));
    }
}
?>
