<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class TemperatureAnswerTest extends PHPUnit_Framework_TestCase
{
    public function test_no_rounding_temperature_and_holding_steady() {
        $testee = new TemperatureAnswer($this->create_weather_json('5.0', '0'));
        $this->assertSame(
            '<speak>The temperature is 5 degrees celsius.<break time="1s"/>The temperature is holding steady.</speak>',
            $testee->generate());
    }

    public function test_round_temperature_up_and_trending_up() {
        $testee = new TemperatureAnswer($this->create_weather_json('5.6', '1'));
        $this->assertSame(
            '<speak>The temperature is 6 degrees celsius.<break time="1s"/>The temperature is trending up.</speak>',
            $testee->generate());
    }

    public function test_round_temperature_down_and_trending_down() {
        $testee = new TemperatureAnswer($this->create_weather_json('-5.5', '-1'));
        $this->assertSame(
            '<speak>The temperature is -5 degrees celsius.<break time="1s"/>The temperature is trending down.</speak>',
            $testee->generate());
    }

    public function test_one_degree_temperature() {
        $testee = new TemperatureAnswer($this->create_weather_json('1.0', '0'));
        $this->assertSame(
            '<speak>The temperature is 1 degree celsius.<break time="1s"/>The temperature is holding steady.</speak>',
            $testee->generate());
    }

    public function test_minus_one_degree_temperature() {
        $testee = new TemperatureAnswer($this->create_weather_json('-1.0', '0'));
        $this->assertSame(
            '<speak>The temperature is -1 degrees celsius.<break time="1s"/>The temperature is holding steady.</speak>',
            $testee->generate());
    }

    public function test_missing_temperature() {
        $testee = new TemperatureAnswer($this->create_weather_json(null, '0'));
        $this->assertSame(
            '<speak>The temperature is not known.</speak>',
            $testee->generate());
    }

    public function test_missing_trend() {
        $testee = new TemperatureAnswer($this->create_weather_json('5.0', null));
        $this->assertSame(
            '<speak>The temperature is not known.</speak>',
            $testee->generate());
    }

    private function create_weather_json($degrees_c, $trend) {
        return array(
            "weather" =>
                array('temperature' =>
                    array(
                        'current' => array('c' => $degrees_c),
                        'trend' => $trend)));
    }
}
?>
