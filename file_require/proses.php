<?php
    $user_city = isset($_GET["city"]) ? $_GET["city"] : "";
                        
    $api_url      = "http://api.openweathermap.org/data/2.5/weather?q=" . $user_city . "&appid=0dd9f8ee61a9262afc4338919c7bb5b8";
    $weather_data = file_get_contents($api_url);
    $json         = json_decode($weather_data, TRUE);

    $weather   = isset($weather) ? $weather : "";
    $user_temp = isset($user_temp) ? $user_temp : "";
    $weather_dateupdatenew = isset($weather_dateupdatenew) ? $weather_dateupdatenew : "";

    if (isset($json["main"]) && isset($json["weather"]) && isset($json["dt"])) { 
        $weather_dateupdate = $json["dt"]; 
        $user_temp = $json["main"]["temp"]; 
        $weather = $json["weather"][0]["main"]; 
        $weather_dateupdatenew = date("d M Y", $weather_dateupdate);
    }
    
    echo "The weather of " . $user_city . " at " . $weather_dateupdatenew . " is " . $weather;
    
    $data = "file_require/data.json";
    $json_string = json_encode($_GET, JSON_PRETTY_PRINT);
    file_put_contents($data, $json_string, FILE_APPEND);