<?php

function up($db, $tracksDatas){
    $counter = 0;
    foreach($tracksDatas->tracks as $track){

        if($track !== null) {

            // User seeder
            $username = $track->album->artists[0]->name;
            $trackName = $track->name;
            $img = $track->album->images[0]->url;
            $email = str_replace(' ','_',trim($username . "@spotify.com"));
            $password = password_hash("Spotify1",PASSWORD_DEFAULT);
            $birth = "1970-10-07";
            $role = 2;
            $gender = "Male";

            // Artist seeder
            $description = "Hey I'm an artist on spotify, come check on me !";

            // Track seeder
            $counter ++;
            $category_id = rand(1,2);
            $audioLink = $track->preview_url ?? "nopreview-$counter.mp3";
            $audioduration = $track->duration_ms ?? "nopreview-$counter.mp3";
            
            // Check existing username

            $sql ="SELECT COUNT(username) as userCount, COUNT(email) as userEmail FROM users WHERE `username` = :username OR email = :email";
            $request = $db->prepare($sql);
            $request->bindValue(':username', $username);
            $request->bindValue(':email', $email);
            $request->execute();

            $result = $request->fetch(PDO::FETCH_ASSOC);

            $userCount = $result['userCount'];
            $userEmail = $result['userEmail'];
            
            // echo $userCount."\n";
            // echo $userEmail;
            // exit;
            if($userCount == 0 && $userEmail == 0){

                $sql ="INSERT INTO users (`username`, email, password, birth, role, gender, profile_picture)  VALUES (:username, :email, :password, :birth, :role, :gender, :profile_picture)";
                $request = $db->prepare($sql);
                $request->bindValue(':username', $username);
                $request->bindValue(':email', $email);
                $request->bindValue(':password', $password);
                $request->bindValue(':birth', $birth);
                $request->bindValue(':role', $role);
                $request->bindValue(':gender', $gender );
                $request->bindValue(':profile_picture', $img);
                $request->execute();
                $lastUserInsertId = $db->lastInsertId();      
                        
                if($lastUserInsertId){

                    $sql = $db->prepare("INSERT INTO artists (`name`, profile_picture, description, user_id ) VALUES (:name, :profile_picture, :description, :user_id)");

                    $sql->bindParam(':name', $username);
                    $sql->bindParam(':profile_picture',$img);
                    $sql->bindParam(':description',$description);
                    $sql->bindParam(':user_id',$lastUserInsertId);
                    $sql->execute();
                }
            }

            $sql ="SELECT id FROM artists WHERE `name` = :name";
            $request = $db->prepare($sql);
            $request->bindValue(':name', $username);
            $request->execute();
            $artistInsertId = $request->fetch(PDO::FETCH_ASSOC);            

            if($artistInsertId){

                $sql ="SELECT audio_link FROM tracks WHERE `artist_id` = :artist_id AND audio_link = :audio_link";
                $request = $db->prepare($sql);
                $request->bindValue(':artist_id', $artistInsertId['id']);
                $request->bindValue(':audio_link',$audioLink);
                $request->execute();
                $audioId = $request->fetch(PDO::FETCH_ASSOC);

                // $sql->bindParam(':profile_picture', json_encode($track->album->images)); // Assuming images is a JSON string
                
                if($audioId['audio_link'] !== $audioLink && $audioLink !== null){
                    // A rajouter Image !
                    $sql = $db->prepare("INSERT INTO tracks (title, artist_id, duration, audio_link, category_id) VALUES (:title, :artist_id, :duration, :audio_link, :category_id)");

                    $sql->bindParam(':title', $trackName);
                    $sql->bindParam(':duration', $audioduration);
                    $sql->bindParam(':artist_id', $artistInsertId['id']);
                    $sql->bindParam(':audio_link', $audioLink);
                    $sql->bindParam(':category_id',$category_id );           
                    $sql->execute();

                }
                       
            }

        }
    } 
}

up($db,$tracksDatas);