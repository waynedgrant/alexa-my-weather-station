<?php header('Content-Type: application/json');

    set_include_path(get_include_path() . PATH_SEPARATOR . './Alexa/Request/');
    set_include_path(get_include_path() . PATH_SEPARATOR . './Alexa/Response/');

    include_once('Request.php');
    include_once('IntentRequest.php');
    include_once('User.php');
    include_once('OutputSpeech.php');
    include_once('Response.php');

    function getFieldsFromLocation($location)
    {
        $fieldDelimiter = ' ';
        $fields = array();

        if (is_readable($location) || filter_var($location, FILTER_VALIDATE_URL))
        {
            $clientRawFile = fopen($location, 'r');

            if ($clientRawFile)
            {
                $clientRawText = '';

                while (!feof($clientRawFile))
                {
                    $clientRawText .= fread($clientRawFile, 8192);
                }

                fclose($clientRawFile);

                if (strlen($clientRawText) != 0)
                {
                    $fields = explode($fieldDelimiter, trim($clientRawText));
                }
            }
        }

        return $fields;
    }

    function parse_trend($trend)
    {
        if ($trend > 0)
        {
            return 'rising';
        }
        else if ($trend < 0)
        {
            return 'falling';
        }
        else
        {
            return 'steady';
        }
    }

    $echo_array = json_decode(file_get_contents('php://input'), true);

    $alexaRequest = \Alexa\Request\Request::fromData($echo_array);

    $answer = 'The answer to that is unknown';

    if ($alexaRequest instanceof \Alexa\Request\IntentRequest) {

        $intent = $alexaRequest->intentName;

        $location = '../meteohub/clientraw.txt';

        $clientraw_fields = getFieldsFromLocation($location);

        switch ($intent)
        {
            case "CurrentHumidityIntent":
                $current_humidity = $clientraw_fields[5];
                $humidity_trend = parse_trend($clientraw_fields[144]);
                $answer = 'The current humidity is ' . $current_humidity . ' percent and is ' . $humidity_trend . '.';
                break;
            case "CurrentPressureIntent":
                $current_pressure = $clientraw_fields[6];
                $pressure_trend = parse_trend($clientraw_fields[50]);
                $answer = 'The current pressure is ' . $current_pressure . ' hectopascals and is ' . $pressure_trend . '.';
                break;
            case "CurrentTemperatureIntent":
                $current_temperature = $clientraw_fields[4];
                $temperature_trend = parse_trend($clientraw_fields[143]);
                $answer = 'The current temperature is ' . $current_temperature . ' degrees celsius and is ' . $temperature_trend . '.';
                break;
        }
    }

    $response = new Alexa\Response\Response;
    $response->respond($answer)->endSession();

    echo json_encode($response->render());

    exit;
?>
