<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once("BaseAnswer.php");

class PressureAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $pressure_json = $this->weather_json['weather']['pressure'];
        $pressure = $this->round_value($pressure_json['current']['mb']);
        $pressure_trend = $this->parse_trend($pressure_json['trend']);
        return $this->speak(
            'The pressure is ' . $pressure . ' millibar' . $this->add_plural($pressure) . '.' .
            '<break time="1s"/>' .
            'The pressure is ' . $pressure_trend . '.');
    }
}

?>
