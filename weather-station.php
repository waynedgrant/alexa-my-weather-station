<?php header('Content-Type: application/json');

    set_include_path(get_include_path() . PATH_SEPARATOR . './Alexa/Request/');
    set_include_path(get_include_path() . PATH_SEPARATOR . './Alexa/Response/');

    include_once('Request.php');
    include_once('IntentRequest.php');
    include_once('User.php');
    include_once('OutputSpeech.php');
    include_once('Response.php');

    function parse_trend($trend) {

        if ($trend > 0) {
            return 'trending up';
        }
        else if ($trend < 0) {
            return 'trending down';
        }
        else {
            return 'holding steady';
        }
    }

    function parse_cardinal_direction($direction) {

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

    function weather_answer($weather_json) {
        return
            temperature_answer($weather_json) . ' ' .
            '<break time="2s"/>' .
            pressure_answer($weather_json) . ' ' .
            '<break time="2s"/>' .
            rainfall_answer($weather_json) . ' ' .
            '<break time="2s"/>' .
            wind_answer($weather_json) . ' ' .
            '<break time="2s"/>' .
            humidity_answer($weather_json) . ' ' .
            '<break time="2s"/>' .
            uv_answer($weather_json);
    }

    function humidity_answer($weather_json) {
        $humidity_json = $weather_json['humidity'];
        $humidity = $humidity_json['current'];
        $humidity_trend = parse_trend($humidity_json['trend']);
        return 'The humidity is ' . $humidity . ' percent and is ' . $humidity_trend . '.';
    }

    function pressure_answer($weather_json) {
        $pressure_json = $weather_json['pressure'];
        $pressure = $pressure_json['current']['kpa'];
        $pressure_trend = parse_trend($pressure_json['trend']);
        return 'The pressure is ' . $pressure . ' kilopascals and is ' . $pressure_trend . '.';
    }

    function rainfall_answer($weather_json) {
        $rainfall_json = $weather_json['rainfall'];
        $rainfall_today = $rainfall_json['daily']['mm'];
        $rainfall_rate_per_min = $rainfall_json['rate_per_min']['mm'];
        return 'Today\'s rain fall so far is ' . $rainfall_today . ' millimeters.' .
               '<break time="1s"/>' .
               'The current rain fall rate is ' . $rainfall_rate_per_min . ' millimeters per minute.';
    }

    function temperature_answer($weather_json) {
        $temperature_json = $weather_json['temperature'];
        $temperature = $temperature_json['current']['c'];
        $temperature_trend = parse_trend($temperature_json['trend']);
        return 'The temperature is ' . $temperature . ' degrees celsius and is ' . $temperature_trend . '.';
    }

    function uv_answer($weather_json) {
        $uv_json = $weather_json['uv'];
        $uv_index = $uv_json['uvi'];
        $uv_index_description = $uv_json['description'];
        return 'The UV is ' . $uv_index_description . ' with an index value of ' . $uv_index . '.';
    }

    function wind_answer($weather_json) {
        $wind_json = $weather_json['wind'];
        $wind_speed = $wind_json['avg_speed']['kmh'];
        $wind_direction = $wind_json['direction']['cardinal'];
        return 'The windspeed is ' . $wind_speed . ' kilometers per hour blowing from the ' . parse_cardinal_direction($wind_direction) . '.';
    }

    function prepare_answer($alexaRequest) {

        $answer = 'Your weather station cannot tell you that.';

        if ($alexaRequest instanceof \Alexa\Request\IntentRequest) {

            $intent = $alexaRequest->intentName;

            $response = file_get_contents('https://waynedgrant.com/weather/api/weather.json');
            $weather_json = json_decode($response, true)['weather'];

            switch ($intent) {
                case 'WeatherIntent':
                    $answer = weather_answer($weather_json); break;
                case 'HumidityIntent':
                    $answer = humidity_answer($weather_json); break;
                case 'PressureIntent':
                    $answer = pressure_answer($weather_json); break;
                case 'RainfallIntent':
                    $answer = rainfall_answer($weather_json); break;
                case 'TemperatureIntent':
                    $answer = temperature_answer($weather_json); break;
                case 'UvIntent':
                    $answer = uv_answer($weather_json); break;
                case 'WindIntent':
                    $answer = wind_answer($weather_json); break;
            }
        }

        return '<speak>' . $answer . '</speak>';
    }

    $echo_array = json_decode(file_get_contents('php://input'), true);

    $alexaRequest = \Alexa\Request\Request::fromData($echo_array);

    $answer = prepare_answer($alexaRequest);

    $response = new Alexa\Response\Response;
    $response->respond($answer)->endSession();

    echo json_encode($response->render());

    exit;
?>
