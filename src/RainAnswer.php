<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once('BaseAnswer.php');

class RainAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $rainfall_json = $this->weather_json['weather']['rainfall'];

        $rainfall_today = $rainfall_json['daily']['mm'];

        if (is_null($rainfall_today)) {
            return $this->speak('The rain fall conditions are not known.');
        }

        $rainfall_today = $this->round_value($rainfall_today);

        if ($rainfall_today > 0) {
            return $this->speak(
                'Today\'s rain fall is ' . $rainfall_today . ' millimetre' . $this->add_plural($rainfall_today) . '.');
        } else {
            return $this->speak('There has been no rain so far today.');
        }
    }
}

?>
