<?php 
require $_SERVER['DOCUMENT_ROOT'] . '../config/spotify_access.php';
require $_SERVER['DOCUMENT_ROOT'] . '../models/DatabaseConnection.php';
require $_SERVER['DOCUMENT_ROOT'] . '../models/User.php';
$client = new DatabaseConnection();
$db = $client->get_pdo();

function up($db, $tracksDatas){

    foreach($tracksDatas as $k => $tracks){


        $name = $tracks[0]->artists[0]->name;
        $img = $tracks[0]->album->images;
        $email = $name . "@spotify.com";
        $password = $name;
        $birth = "1970-10-07";
        $gender = "Male";
        

        $sql ="INSERT INTO users (`username`, email, password, birth, gender, profile_picture)  VALUES (:username, :email, :password, :birth, :gender, :profile_picture)";
        $request = $db->prepare($sql);
        $request->bindValue(':username', $name);
        $request->bindValue(':email', $email);
        $request->bindValue(':password', $password);
        $request->bindValue(':birth', $birth);
        $request->bindValue(':gender', $gender );
        $request->bindValue(':profile_picture', $img);
        $request->execute();

        
    // var_dump("Spotify_artist_name",$tracksDatas->tracks[0]->artists[0]->name);
    // var_dump("Spotify_images",$tracksDatas->tracks[0]->album->images);
    // var_dump("Spotify_href",$tracksDatas->tracks[0]->href);
    // var_dump("Spotify_track_name",$tracksDatas->tracks[0]->name);
    // var_dump("Spotify_track_preview_url",$tracksDatas->tracks[0]->preview_url);

    }
}

up($db,$tracksDatas);