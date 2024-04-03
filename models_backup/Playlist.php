<?php

    class Playlist {

        private $db;

        public function __construct($db) {
            $this->db = $db;
        }
        /**
         * Crée une playlist et retourne l'id de cette dernière.
         */
        public function create_playlist($user_id):int{

            $imagesToShow = '../public/ressources/Spotify_Images';
            $images = glob($imagesToShow . '/*.jpeg');
            $imageSource = $images[rand(0,4)];

            $request=$this->db->prepare("SELECT count(id) FROM playlists WHERE user_id = :id");
            $request->bindValue(':id', $user_id);
            $request->execute();
            $counter = $request->fetchColumn();
        
            $request = $this->db->prepare("INSERT INTO playlists (title, img, `user_id`, description) VALUES (:title, :img, :user_id, :description)");
            $request->bindValue(":title", "Ma playlist N°" . $counter+1);
            $request->bindValue(":img", $imageSource);
            $request->bindValue(":user_id", $user_id);
            $request->bindValue(":description","Default description");
            $request->execute();

            $playlistId = $this->db->lastInsertId();

            return $playlistId;
        }

        public function open_playlist($playlist_id){
            $request = $this->db->prepare("SELECT * FROM playlists WHERE (id = :playlist_id)");
            $request->bindValue(':playlist_id', $playlist_id);
            $request->execute();
            $result = $request->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        public function show_my_playlist(array $playlistIds){
           
            // Apparement lors d'une utilisation d'un tableau déléments,tel que cette situation, nous sommes "obligés" de renseigner un placeholder anonyme. Sinon la requête echoue, cependant, ce placeholder se base sur le nombre d'élements recus.

            // On défini donc une variable qui sera un tableau remplis par array_fill, commençant à l'index "0","count" pour compter le nombre d'éléments à mettre dans ce nouveau tableau et enfin "?" pour la valeur qu'il faut inclure dans ce tableau.
            if(!empty($playlistIds)):
                $placeholders = array_fill( 0 , count(array_map(function($value){
                    // var_dump("Valuetab:",$value['playlist_id']);
                    return trim($value['playlist_id']);
                },$playlistIds)),'?');

                $placeholders = implode(',',$placeholders );
                $request = $this->db->prepare("SELECT id, title, img, `user_id` FROM playlists WHERE id IN ($placeholders)");
                foreach ($playlistIds as $index => $playlist) {
                    $request->bindValue($index + 1, $playlist['playlist_id'], PDO::PARAM_INT);
                }

                $request->execute();
                $result = $request->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            else:
                return false;
            endif;
        }
        public function show_playlist(){
            $request = $this->db->prepare("SELECT * FROM playlists");
            $request->execute();
            return $request->fetchAll(PDO::FETCH_ASSOC);
        }

        public function show_public_playlist(){
            $request = $this->db->prepare("SELECT * FROM playlists WHERE privacy = 1");
            $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }



        public function delete_playlist($playlistId) {

            $request = $this->db->prepare("DELETE FROM playlists WHERE (id = :playlistId)");
            $request->bindValue(':playlistId', $playlistId);
            $request->execute();
        
        }

        public function get_creator_name(int $playlist_user_id):string{

            $request = $this->db->prepare("SELECT username FROM users WHERE (id = :playlist_user_id)");
            $request->bindValue(':playlist_user_id', $playlist_user_id);
            $request->execute();
           
            $result = $request->fetch(PDO::FETCH_ASSOC);
          
            return $result['username'];
        }

        public function updatePlaylist(array $datas,$files){

            if(!empty($files) && ($files['userImgUpdate']['size'] > 0)){
                $extension = pathinfo($_FILES['userImgUpdate']['name'], PATHINFO_EXTENSION);
                $fileName = $datas['user_id'] . '-playlist-picture';
                $uploadDir = ".." . MY_RELATIVE_PATH_TO_PLAYLIST_IMAGE;
                $uploadFile = $uploadDir . $fileName . '.'.$extension;
        
                array_map('unlink', glob($uploadDir . $fileName . '.*'));
                move_uploaded_file($_FILES['userImgUpdate']['tmp_name'], $uploadFile);
        
                $query = "UPDATE users SET img = :img";
                $request = $this->db->prepare($query);
                $request->execute([
                    "img" => $uploadFile
                ]);
        
            }
            
            $request = $this->db->prepare("UPDATE playlists SET title = :title, `description` = :description, privacy = :privacy, updated_at = NOW() WHERE id = :id");
            $request->bindValue(':title', $datas['updatePlaylistTitle']);
            $request->bindValue(':description', $datas['updatePlaylistDescription']);
            $request->bindValue(':privacy', $datas['updatePlaylistPrivacy']);
            $request->bindValue(':id', $datas['updatePlaylstId']);
            $request->execute();

            $result = $request->rowCount();

            if ($result > 0){

                $request = $this->db->prepare("SELECT title,`description`, img, privacy, id, `user_id` FROM playlists WHERE id = :id");
                $request->bindValue(':id', $datas['updatePlaylstId']);
                $request->execute();
                $result = $request->fetch(PDO::FETCH_ASSOC);
                return $result;
            }
        }
    }