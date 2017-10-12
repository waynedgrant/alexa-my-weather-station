<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once('BaseAnswer.php');

class DewPointAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $dew_point_json = $this->weather_json['weather']['dew_point'];

        $dew_point = $dew_point_json['current']['c'];

        if (is_null($dew_point)) {
            return $this->speak('The dew point is not known.');
        }

        $dew_point = $this->round_value($dew_point);

        return $this->speak(
            'The dew point is ' . $dew_point . ' degree' . $this->add_plural($dew_point) . ' celsius.');
    }
}

?>
