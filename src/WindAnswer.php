<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once('BaseAnswer.php');

class WindAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    private function parse_cardinal_direction($direction) {
        $description = 'Unknown';

        switch ($direction) {
            case 'N': $description = 'North'; break;
            case 'NNE': $description = 'North-North-East'; break;
            case 'NE': $description = 'North-East'; break;
            case 'ENE': $description = 'East-North-East'; break;
            case 'E': $description = 'East'; break;
            case 'ESE': $description = 'East-South-East'; break;
            case 'SE': $description = 'South-East'; break;
            case 'SSE': $description = 'South-South-East'; break;
            case 'S': $description = 'South'; break;
            case 'SSW': $description = 'South-South-West'; break;
            case 'SW': $description = 'South-West'; break;
            case 'WSW': $description = 'West-South-West'; break;
            case 'W': $description = 'West'; break;
            case 'WNW': $description = 'West-North-West'; break;
            case 'NW': $description = 'North-West'; break;
            case 'NNW': $description = 'North-North-West'; break;
        }

        return $description;
    }

    public function generate() {
        $wind_json = $this->weather_json['weather']['wind'];
        $wind_speed = $this->round_value($wind_json['avg_speed']['kmh']);

        if ($wind_speed > 0) {
            $wind_direction = $wind_json['direction']['cardinal'];
            return $this->speak(
                'The wind speed is ' . $wind_speed . ' kilometer' . $this->add_plural($wind_speed) . ' per hour.' .
                '<break time="1s"/>' .
                'The wind is blowing from the ' . $this->parse_cardinal_direction($wind_direction) . '.');
        } else {
            return $this->speak('There wind is completely calm.');
        }
    }
}

?>
