<?php

define("MY_USERS_FILE",dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'users.csv');
define("MY_USERS_PDO",[
    'email',
    'password',
    'username',
    'birth',
    'gender',
    'recover_token'
]);
define("MY_PLAYLIST_DEFAULT_IMAGES", "." . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "ressources" . DIRECTORY_SEPARATOR . "Spotify_Images");

define("MY_RELATIVE_PATH_TO_USER_IMAGE", "/public/ressources/users_image/");
define("MY_RELATIVE_PATH_TO_PLAYLIST_IMAGE", "/public/ressources/playlists_image/");
