<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class UvAnswerTest extends PHPUnit\Framework\TestCase
{
    public function test_no_rounding_uvi() {
        $testee = new UvAnswer($this->create_weather_json('2.0', 'low'));
        $this->assertSame(
            '<speak>The UV index is 2 which is low.</speak>',
            $testee->generate());
    }

    public function test_round_uvi_up() {
        $testee = new UvAnswer($this->create_weather_json('6.6', 'high'));
        $this->assertSame(
            '<speak>The UV index is 7 which is high.</speak>',
            $testee->generate());
    }

    public function test_round_uvi_down() {
        $testee = new UvAnswer($this->create_weather_json('8.5', 'very high'));
        $this->assertSame(
            '<speak>The UV index is 8 which is very high.</speak>',
            $testee->generate());
    }
    public function test_missing_uvi() {
        $testee = new UvAnswer($this->create_weather_json(null, 'low'));
        $this->assertSame(
            '<speak>The UV index is not known.</speak>',
            $testee->generate());
    }

    public function test_missing_description() {
        $testee = new UvAnswer($this->create_weather_json('2.0', null));
        $this->assertSame(
            '<speak>The UV index is not known.</speak>',
            $testee->generate());
    }

    private function create_weather_json($uvi, $description) {
        return array(
            "weather" =>
                array('uv' =>
                    array(
                        'uvi' => $uvi,
                        'description' => $description)));
    }
}
?>
