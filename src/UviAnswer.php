<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once("BaseAnswer.php");

class UviAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $uv_json = $this->weather_json['weather']['uv'];
        $uv_index = $this->round_value($uv_json['uvi']);
        $uv_index_description = $uv_json['description'];
        return $this->speak(
            'The UV Index is ' . $uv_index . '.' .
            '<break time="1s"/>' .
            'The UV is ' . $uv_index . '.');
    }
}

?>
