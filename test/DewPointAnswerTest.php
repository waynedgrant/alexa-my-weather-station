<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class DewPointAnswerTest extends PHPUnit\Framework\TestCase
{
    public function test_no_rounding_dew_point() {
        $testee = new DewPointAnswer($this->create_weather_json('5.0'));
        $this->assertSame(
            '<speak>The dew point is 5 degrees celsius.</speak>',
            $testee->generate());
    }

    public function test_round_dew_point_up() {
        $testee = new DewPointAnswer($this->create_weather_json('5.6'));
        $this->assertSame(
            '<speak>The dew point is 6 degrees celsius.</speak>',
            $testee->generate());
    }

    public function test_round_dew_point_down() {
        $testee = new DewPointAnswer($this->create_weather_json('-5.5'));
        $this->assertSame(
            '<speak>The dew point is -5 degrees celsius.</speak>',
            $testee->generate());
    }

    public function test_zero_degrees_dew_point() {
        $testee = new DewPointAnswer($this->create_weather_json('0.0'));
        $this->assertSame(
            '<speak>The dew point is 0 degrees celsius.</speak>',
            $testee->generate());
    }

    public function test_one_degree_dew_point() {
        $testee = new DewPointAnswer($this->create_weather_json('1.0'));
        $this->assertSame(
            '<speak>The dew point is 1 degree celsius.</speak>',
            $testee->generate());
    }

    public function test_minus_one_degrees_dew_point() {
        $testee = new DewPointAnswer($this->create_weather_json('-1.0'));
        $this->assertSame(
            '<speak>The dew point is -1 degrees celsius.</speak>',
            $testee->generate());
    }

    public function test_missing_dew_point() {
        $testee = new DewPointAnswer($this->create_weather_json(null));
        $this->assertSame(
            '<speak>The dew point is not known.</speak>',
            $testee->generate());
    }

    private function create_weather_json($degrees_c) {
        return array(
            "weather" =>
                array('dew_point' =>
                    array(
                        'current' => array('c' => $degrees_c))));
    }
}
?>
