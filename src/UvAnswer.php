<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once('BaseAnswer.php');

class UvAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        $uv_json = $this->weather_json['weather']['uv'];

        $uv_index = $uv_json['uvi'];
        $uv_index_description = $uv_json['description'];

        if (is_null($uv_index) || is_null($uv_index_description)) {
            return $this->speak('The UV index is not known.');
        }

        $uv_index = $this->round_value($uv_index);

        return $this->speak(
            'The UV index is ' . $uv_index . '.' .
            '<break time="1s"/>' .
            'The UV is ' . $uv_index_description . '.');
    }
}

?>
