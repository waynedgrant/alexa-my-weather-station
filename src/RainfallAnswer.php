<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once("BaseAnswer.php");

class RainfallAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $rainfall_json = $this->weather_json['weather']['rainfall'];
        $rainfall_today = $this->round_value($rainfall_json['daily']['mm']);
        $rainfall_rate_per_min = $rainfall_json['rate_per_min']['mm'];
        return $this->speak(
            'Today\'s rain fall so far is ' . $rainfall_today . ' millimetre' . $this->add_plural($rainfall_today) . '.' .
            '<break time="1s"/>' .
            'The current rain fall rate is ' . $rainfall_rate_per_min . ' millimetre' . $this->add_plural($rainfall_rate_per_min) . ' per minute.');
    }
}

?>
