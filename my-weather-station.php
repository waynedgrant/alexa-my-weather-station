<?php header('Content-Type: application/json');

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once("WeatherAnswer.php");
require_once("HumidityAnswer.php");
require_once("PressureAnswer.php");
require_once("RainfallAnswer.php");
require_once("TemperatureAnswer.php");
require_once("UviAnswer.php");
require_once("WindAnswer.php");
require_once("DefaultAnswer.php");

function prepare_answer($intent) {

    $wdlive_url = 'https://waynedgrant.com/weather/api/weather.json';

    $weather_response = file_get_contents($wdlive_url);
    $weather_json = json_decode($weather_response, true);

    switch ($intent) {
        case 'WeatherIntent':
            $answer = new WeatherAnswer($weather_json); break;
        case 'HumidityIntent':
            $answer = new HumidityAnswer($weather_json); break;
        case 'PressureIntent':
            $answer = new PressureAnswer($weather_json); break;
        case 'RainfallIntent':
            $answer = new RainfallAnswer($weather_json); break;
        case 'TemperatureIntent':
            $answer = new TemperatureAnswer($weather_json); break;
        case 'UviIntent':
            $answer = new UviAnswer($weather_json); break;
        case 'WindIntent':
            $answer = new WindAnswer($weather_json); break;
        default:
            $answer = new DefaultAnswer($weather_json);
    }

    return $answer->generate();
}

function render_response($answer) {
	return [
		'version' => '1.0',
		'response' => [
			'outputSpeech' => [
    			'type' => 'SSML',
    			'ssml' => $answer
			],
			'shouldEndSession' => true
		]
	];
}

$alexa_request = json_decode(file_get_contents('php://input'), true);
$intent = $alexa_request['request']['intent']['name'];

$answer_text = prepare_answer($intent);
error_log($answer_text);
echo json_encode(render_response($answer_text));

exit;
?>
