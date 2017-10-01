<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once("BaseAnswer.php");
require_once("HumidityAnswer.php");
require_once("PressureAnswer.php");
require_once("RainfallAnswer.php");
require_once("TemperatureAnswer.php");
require_once("UviAnswer.php");
require_once("WindAnswer.php");

class WeatherAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    private function remove_speak($answer) {
        $answer = str_replace('<speak>', '', $answer);
        $answer = str_replace('</speak>', '', $answer);
        return $answer;
    }

    public function generate() {

        $temperature_answer = new TemperatureAnswer($this->weather_json);
        $pressure_answer = new PressureAnswer($this->weather_json);
        $rainfall_answer = new RainfallAnswer($this->weather_json);
        $wind_answer = new WindAnswer($this->weather_json);
        $humidity_answer = new HumidityAnswer($this->weather_json);
        $uvi_answer = new UviAnswer($this->weather_json);

        return $this->speak(
            $this->remove_speak($temperature_answer->generate()) . '<break time="2s"/>' .
            $this->remove_speak($pressure_answer->generate()) . '<break time="2s"/>' .
            $this->remove_speak($rainfall_answer->generate()) . '<break time="2s"/>' .
            $this->remove_speak($wind_answer->generate()) . '<break time="2s"/>' .
            $this->remove_speak($humidity_answer->generate()) . '<break time="2s"/>' .
            $this->remove_speak($uvi_answer->generate()));
    }
}

?>
