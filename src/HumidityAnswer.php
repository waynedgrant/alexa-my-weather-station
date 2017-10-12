<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once('BaseAnswer.php');

class HumidityAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $humidity_json = $this->weather_json['weather']['humidity'];

        $humidity = $humidity_json['current'];
        $humidity_trend = $humidity_json['trend'];

        if (is_null($humidity) || is_null($humidity_trend)) {
            return $this->speak('The humidity is not known.');
        }

        $humidity_trend = $this->parse_trend($humidity_trend);

        return $this->speak(
            'The humidity is ' . $humidity . ' percent and is ' . $humidity_trend . '.');
    }
}

?>
