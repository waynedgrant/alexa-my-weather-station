<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

class WeatherAnswerTest extends PHPUnit_Framework_TestCase
{
    public function test_weather() {
        $testee = new WeatherAnswer($this->create_weather_json());
        $this->assertSame(
            '<speak>The temperature is not known.<break time="1s"/>' .
            'The humidity is not known.<break time="1s"/>' .
            'The dew point is not known.<break time="1s"/>' .
            'The pressure is not known.<break time="1s"/>' .
            'The rain fall conditions are not known.<break time="1s"/>' .
            'The wind conditions are not known.<break time="1s"/>' .
            'The UV index is not known.</speak>',
            $testee->generate());
    }

    private function create_weather_json() {
        return array(
            "weather" =>
                array('dew_point' =>
                    array(
                        'current' => array('c' => $degrees_c))),
                array('humidity' =>
                    array(
                        'current' => $humidity,
                        'trend' => $trend)),
                array('pressure' =>
                    array(
                        'current' => array('mb' => $pressure_mb),
                        'trend_per_hr' => array('mb' => $trend))),
                array('rainfall' =>
                    array(
                        'daily' => array('mm' => $daily_rainfall_mm))),
                array('temperature' =>
                    array(
                        'current' => array('c' => $degrees_c),
                        'trend' => $trend)),
                array('uv' =>
                    array(
                        'uvi' => $uvi,
                        'description' => $description)),
                array('wind' =>
                    array(
                        'avg_speed' => array('kmh' => $wind_kmh),
                        'direction' => array('cardinal' => $wind_direction))));
    }
}
?>
