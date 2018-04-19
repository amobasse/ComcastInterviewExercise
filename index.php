<!-- Comcast Interview Exercise
Armin Mobasseri
04/19/2018 

Output weather information about Philadelphia from the Weather Underground API and output a SQL statement inserting temp and humidity into a mock database. -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Comcast Coding Exercise</title>
</head>

<body>

<?php

// importing a class
require_once('WeatherPopulator.php');

// protection against MITM attacks
$context = stream_context_create(array('ssl' => array('verify_peer' => TRUE)));

// the values for the API url
$apiKey = "cd7751d9b3c027af";
$city = "Philadelphia";
$state = "PA";
$request = "conditions";

// the values get plugged into the API link here
$url = "http://api.wunderground.com/api/" . $apiKey . "/" . $request . "/q/" . $state. "/" . $city . ".json";

// plug in url, get the JSON from the API
$json_string = file_get_contents($url, false, $context);
$parsed_json = json_decode($json_string);

// getting key data for the SQL statement
$location = $parsed_json->{'location'}->{'city'};
$temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
$humidity = $parsed_json->{'current_observation'}->{'relative_humidity'};

// the API TOS states that need to display the watermark
$watermark = $parsed_json->{'current_observation'}->{'image'}->{'url'};

// this is just a mockup as requested by the exercise, but normally I would prepare and bind the
// values I collected above for this statement
// but since the exercise asked for just the INSERT statement, I am outputting it here
// this kind of statement has the benefit of additional protection against injection
$sql = "INSERT INTO weatherConditions (city, temp, humidity, requestTime) VALUES (?, ?, ?, CURRENT_TIMESTAMP);";
echo $sql;

// populate the page with html table of temperature data
// I found a few existing libraries for using the weather API but I would need more time
// to validate how they worked and their security, so I made something simple on my own
// for the purposes of this exercise
echo WeatherPopulator::jsonToHTML($json_string);

// display watermark
echo "<br><br><img src='{$watermark}'>";
?>


</body>
</html>