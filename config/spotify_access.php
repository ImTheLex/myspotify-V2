<?php

function fetchAccessToken(){

    $envFile = __DIR__ . '../../.env';
    $envVariables = parse_ini_file($envFile);

    $clientId = $envVariables["CLIENT_SPOTIFY_ID"];
    $clientSecret = $envVariables["CLIENT_SPOTIFY_SECRET"];
    
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => "Accept: application/json\r\n" .
                        "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => 'grant_type=client_credentials&client_id='.$clientId.'&client_secret='.$clientSecret
        ]
    ];

    $context = stream_context_create($opts);
    $result = file_get_contents('https://accounts.spotify.com/api/token', false, $context);

    $data = json_decode($result);
    $dataToken = $data->access_token;

    return $dataToken;
}

$token = fetchAccessToken();



function fetchSeveralTracksData ($accesstoken) {


    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => "Accept: application/json\r\n" .
                        "Authorization: Bearer " . $accesstoken . "\r\n"
        ]
    ];

     
    $context = stream_context_create($opts);
    $result = file_get_contents('https://api.spotify.com/v1/tracks?ids=5k38wzpLb15YgncyWdTZE4,3nh5RSXnRSHWuQbOJvQr0g,40YcuQysJ0KlGQTeGUosTC,1v7L65Lzy0j0vdpRjJewt1,'
    // 5It9sRLGfnqFeroVSy1ebc,4szdK6sb0M8rFqd7AroyXm,3jevgr3fYdv9wYO3IDJq2a,5MtzlELTZJtuXzFZGtUeun,2ExKb6Ag2WXob6FpkSeXhE,60jzFy6Nn4M0iD1d94oteF,6RHdHHlOAHwFaYS9LUwpYU,23L5CiUhw2jV1OIMwthR3S,4wqIXeDppYSMXaWsnTzpzT,0OI7AFifLSoGzpb8bdBLLV,6zAiRKvAMlXHxEtyO4yxIO,4otT81iBBpaf36roGtzT4a,71vsEyBd4X1D5BUmLdFSVH,7culxZiBjN3w3yXqxgKIpD,6KI1ZpZWYAJLvmVhCJz65G,7jOvEsDIjHRH0LwCkwZSHS,75ZvA4QfFiZvzhj2xkaWAh,6AYs0tPiSYKh18DIwqBLQY,6AoBSeZg9YYt1GKtfcMGkY'
    ,false,$context);

    $data = json_decode($result);
    return $data;
}

$tracksDatas = fetchSeveralTracksData($token);

// var_dump("Spotify_artist_name",$tracksDatas->tracks[0]->artists[0]->name);
// var_dump("Spotify_images",$tracksDatas->tracks[0]->album->images);
// var_dump("Spotify_href",$tracksDatas->tracks[0]->href);
// var_dump("Spotify_track_name",$tracksDatas->tracks[0]->name);
// var_dump("Spotify_track_preview_url",$tracksDatas->tracks[0]->preview_url);



