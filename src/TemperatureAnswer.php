<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once("BaseAnswer.php");

class TemperatureAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $temperature_json = $this->weather_json['weather']['temperature'];
        $temperature = $this->round_value($temperature_json['current']['c']);
        $temperature_trend = $this->parse_trend($temperature_json['trend']);
        return $this->speak(
            'The temperature is ' . $temperature . ' degree' . $this->add_plural($temperature) . ' celsius.' .
            '<break time="1s"/>' .
            'The temperature is ' . $temperature_trend . '.');
    }
}

?>
