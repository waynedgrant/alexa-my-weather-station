# alexa-my-weather-station

Copyright © 2017 Wayne D Grant

Licensed under the MIT License

Service endpoint that implements an Alexa skill that allows the quering of [Weather Display Live](http://www.weather-display.com/wdlive.php)
data that has been exposed via [json-webservice-wdlive](https://github.com/waynedgrant/json-webservice-wdlive). Written in PHP.


## Requirements

1. PHP5 installed on the web server
2. SSL support on the web server
3. Callable instance of [json-webservice-wdlive](https://github.com/waynedgrant/json-webservice-wdlive)

## Installation


### Web Service

* Download the source code for the [latest release](https://github.com/waynedgrant/alexa-my-weather-station/releases) and unzip it

* Modify **alexa-my-weather-station/src/config.php** to point at the **weather.json** endpoint of an instance of **json-webservice-wdlive**, e.g. https://waynedgrant.com/weather/api/weather.json

* Upload all **.php** files in **alexa-my-weather-station/src** to a location on your web server

### Alexa Skill

* Login to the [Alex Developer Site](https://developer.amazon.com/alexa)

* Create a Skill named **My Weather Station**

* Give it an invocation name of **my weather station**

* Supply the following **Intent Schema**:

```json
{
  "intents": [
    {
      "intent": "WeatherIntent"
    },
    {
      "intent": "DewPointIntent"
    },
    {
      "intent": "HumidityIntent"
    },
    {
      "intent": "PressureIntent"
    },
    {
      "intent": "RainIntent"
    },
    {
      "intent": "TemperatureIntent"
    },
    {
      "intent": "UvIntent"
    },
    {
      "intent": "WindIntent"
    }
  ]
}
```

* Supply matching **Sample utterances**:

```
WeatherIntent about the weather
DewPointIntent about the dew point
HumidityIntent about the humidity
PressureIntent about the pressure
RainIntent about the rain
TemperatureIntent about the temperature
UvIntent about the UV
WindIntent about the wind
```

* Configure the endpoint to be the location of **alexa-my-weather-station.php** on your web server

* Install the skill on an Alexa device via the Alexa Mobile app

### Execution

Ask questions of Alexa like:

```
Ask my weather station about the temperature
```

or

```
Ask my weather station about the wind
```

and receive answers of the form:

```
The temperature is 13 degrees celsius and is holding steady
```

and

```
The wind speed is 2 kilometers per hour and is blowing from the South-West
```

## Unit Testing

This project utilizes [PHPUnit](https://phpunit.de/) for unit testing.

* Install [PHPUnit](https://phpunit.de/)
* cd json-webservice-wdlive
* phpunit --bootstrap bootstrap.php test/
