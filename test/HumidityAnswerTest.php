<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class HumidityAnswerTest extends PHPUnit\Framework\TestCase
{
    public function test_holding_steady() {
        $testee = new HumidityAnswer($this->create_weather_json('55', '0'));
        $this->assertSame(
            '<speak>The humidity is 55 percent and is holding steady.</speak>',
            $testee->generate());
    }

    public function test_trending_up() {
        $testee = new HumidityAnswer($this->create_weather_json('56', '1'));
        $this->assertSame(
            '<speak>The humidity is 56 percent and is trending up.</speak>',
            $testee->generate());
    }

    public function test_trending_down() {
        $testee = new HumidityAnswer($this->create_weather_json('57', '-1'));
        $this->assertSame(
            '<speak>The humidity is 57 percent and is trending down.</speak>',
            $testee->generate());
    }

    public function test_missing_humidity() {
        $testee = new HumidityAnswer($this->create_weather_json(null, '0'));
        $this->assertSame(
            '<speak>The humidity is not known.</speak>',
            $testee->generate());
    }

    public function test_missing_trend() {
        $testee = new HumidityAnswer($this->create_weather_json('55', null));
        $this->assertSame(
            '<speak>The humidity is not known.</speak>',
            $testee->generate());
    }

    private function create_weather_json($humidity, $trend) {
        return array(
            "weather" =>
                array('humidity' =>
                    array(
                        'current' => $humidity,
                        'trend' => $trend)));
    }
}
?>
