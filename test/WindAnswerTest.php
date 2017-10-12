<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class WindAnswerTest extends PHPUnit_Framework_TestCase
{
    public function test_no_rounding_wind_speed() {
        $testee = new WindAnswer($this->create_weather_json('5.0', 'N'));
        $this->assertSame(
            '<speak>The wind speed is 5 kilometers per hour.<break time="1s"/>The wind is blowing from the North.</speak>',
            $testee->generate());
    }

    public function test_round_wind_speed_up() {
        $testee = new WindAnswer($this->create_weather_json('5.6', 'N'));
        $this->assertSame(
            '<speak>The wind speed is 6 kilometers per hour.<break time="1s"/>The wind is blowing from the North.</speak>',
            $testee->generate());
    }

    public function test_round_wind_speed_down() {
        $testee = new WindAnswer($this->create_weather_json('5.5', 'N'));
        $this->assertSame(
            '<speak>The wind speed is 5 kilometers per hour.<break time="1s"/>The wind is blowing from the North.</speak>',
            $testee->generate());
    }

    public function test_zero_kmh_wind_speed() {
        $testee = new WindAnswer($this->create_weather_json('0.0', 'N'));
        $this->assertSame(
            '<speak>The wind is completely calm.</speak>',
            $testee->generate());
    }

    public function test_one_kmh_wind_speed() {
        $testee = new WindAnswer($this->create_weather_json('1.0', 'N'));
        $this->assertSame(
            '<speak>The wind speed is 1 kilometer per hour.<break time="1s"/>The wind is blowing from the North.</speak>',
            $testee->generate());
    }

    public function test_directions() {
        $this->direction_test('N', 'North');
        $this->direction_test('NNE', 'North-North-East');
        $this->direction_test('NE', 'North-East');
        $this->direction_test('ENE', 'East-North-East');
        $this->direction_test('E', 'East');
        $this->direction_test('ESE', 'East-South-East');
        $this->direction_test('SE', 'South-East');
        $this->direction_test('SSE', 'South-South-East');
        $this->direction_test('S', 'South');
        $this->direction_test('SSW', 'South-South-West');
        $this->direction_test('SW', 'South-West');
        $this->direction_test('WSW', 'West-South-West');
        $this->direction_test('W', 'West');
        $this->direction_test('WNW', 'West-North-West');
        $this->direction_test('NW', 'North-West');
        $this->direction_test('NNW', 'North-North-West');
    }

    private function direction_test($wind_direction_cardinal, $wind_direction_description) {
        $testee = new WindAnswer($this->create_weather_json('1.0', $wind_direction_cardinal));
        $this->assertSame(
            '<speak>The wind speed is 1 kilometer per hour.<break time="1s"/>The wind is blowing from the ' . $wind_direction_description . '.</speak>',
            $testee->generate());
    }


    public function test_missing_wind_speed() {
        $testee = new WindAnswer($this->create_weather_json(null, '0'));
        $this->assertSame(
            '<speak>The wind conditions are not known.</speak>',
            $testee->generate());
    }

    public function test_missing_trend() {
        $testee = new WindAnswer($this->create_weather_json('5.0', null));
        $this->assertSame(
            '<speak>The wind conditions are not known.</speak>',
            $testee->generate());
    }

    private function create_weather_json($wind_kmh, $wind_direction) {
        return array(
            "weather" =>
                array('wind' =>
                    array(
                        'avg_speed' => array('kmh' => $wind_kmh),
                        'direction' => array('cardinal' => $wind_direction))));
    }
}
?>
