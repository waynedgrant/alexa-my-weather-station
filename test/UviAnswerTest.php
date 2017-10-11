<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class UviAnswerTest extends PHPUnit_Framework_TestCase
{
    public function test_no_rounding_uvi() {
        $testee = new UviAnswer($this->create_weather_json('2.0', 'low'));
        $this->assertSame(
            '<speak>The UV Index is 2.<break time="1s"/>The UV is low.</speak>',
            $testee->generate());
    }

    public function test_round_uvi_up() {
        $testee = new UviAnswer($this->create_weather_json('6.6', 'high'));
        $this->assertSame(
            '<speak>The UV Index is 7.<break time="1s"/>The UV is high.</speak>',
            $testee->generate());
    }

    public function test_round_uvi_down() {
        $testee = new UviAnswer($this->create_weather_json('8.5', 'very high'));
        $this->assertSame(
            '<speak>The UV Index is 8.<break time="1s"/>The UV is very high.</speak>',
            $testee->generate());
    }
    public function test_missing_uvi() {
        $testee = new UviAnswer($this->create_weather_json(null, 'low'));
        $this->assertSame(
            '<speak>The UV index is not known.</speak>',
            $testee->generate());
    }

    public function test_missing_description() {
        $testee = new UviAnswer($this->create_weather_json('2.0', null));
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
