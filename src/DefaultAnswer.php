<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once("BaseAnswer.php");

class DefaultAnswer extends BaseAnswer {

    public function __construct($weather_json) {
        parent::__construct($weather_json);
    }

    public function generate() {
        return $this->speak(
            'Your weather station cannot help you with that.');
    }
}

?>
