<?php header('Content-Type: application/json');

# Copyright 2017 Wayne D Grant (www.waynedgrant.com)
# Licensed under the MIT License

require_once('config.php');
require_once('WeatherAnswer.php');
require_once('DewPointAnswer.php');
require_once('HumidityAnswer.php');
require_once('PressureAnswer.php');
require_once('RainAnswer.php');
require_once('TemperatureAnswer.php');
require_once('UvAnswer.php');
require_once('WindAnswer.php');
require_once('DefaultAnswer.php');

function prepare_answer($intent) {

    $weather_response = file_get_contents(JSON_WEBSERVICE_WDLIVE_LOCATION);

    $weather_json = json_decode($weather_response, true);

    switch ($intent) {
        case 'WeatherIntent':
            $answer = new WeatherAnswer($weather_json); break;
        case 'DewPointIntent':
            $answer = new DewPointAnswer($weather_json); break;
        case 'HumidityIntent':
            $answer = new HumidityAnswer($weather_json); break;
        case 'PressureIntent':
            $answer = new PressureAnswer($weather_json); break;
        case 'RainIntent':
            $answer = new RainAnswer($weather_json); break;
        case 'TemperatureIntent':
            $answer = new TemperatureAnswer($weather_json); break;
        case 'UvIntent':
            $answer = new UvAnswer($weather_json); break;
        case 'WindIntent':
            $answer = new WindAnswer($weather_json); break;
        default:
            $answer = new DefaultAnswer();
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
echo json_encode(render_response($answer_text));

exit;
?>
