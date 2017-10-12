<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once('BaseAnswer.php');

class PressureAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $pressure_json = $this->weather_json['weather']['pressure'];

        $pressure = $pressure_json['current']['mb'];
        $pressure_trend = $pressure_json['trend_per_hr']['mb'];

        if (is_null($pressure) || is_null($pressure_trend)) {
            return $this->speak('The pressure is not known.');
        }

        $pressure = $this->round_value($pressure);
        $pressure_trend = $this->parse_trend($pressure_trend);

        return $this->speak(
            'The pressure is ' . $pressure . ' millibars and is ' . $pressure_trend . '.');
    }
}

?>
