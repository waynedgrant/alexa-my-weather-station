<?php

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

abstract class BaseAnswer {

    protected $weather_json;

    protected function __construct($weather_json = null) {
        $this->weather_json = $weather_json;
    }

    protected function parse_trend($trend) {
        if ($trend > 0) {
            return 'trending up';
        } else if ($trend < 0) {
            return 'trending down';
        } else {
            return 'holding steady';
        }
    }

    protected function round_value($value) {
        return round($value, 0, PHP_ROUND_HALF_DOWN);
    }

    protected function add_plural($value) {
        if ($value != 1) {
            return 's';
        }
        return '';
    }

    protected function speak($answer_text) {
        return '<speak>' . $answer_text . '</speak>';
    }

    abstract public function generate();
}

?>
