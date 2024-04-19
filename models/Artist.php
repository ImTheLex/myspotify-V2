<?php
namespace myspotifyV2\models;
use myspotifyV2\dependencies\MyModel;

require_once '../dependencies/MyModel.php';
class Artist extends MyModel {

    protected $rules = ([
        'id'=>'required|int',
        'name'=>'required|min:3|max:50',
        'description'=>'required|min:3|max:1024',

    ]);

    // public function createArtist(){
    //     $request = $this->db->prepare("INSERT INTO $this->table (name) VALUES (:name)");
    //     $request->execute([
    //         'name'=>'John'
    //     ]);
    // }

    public function createArtist($user_id,$username){

        if($this->validate(['user_id'=> $user_id,'username'=>$username],$this->rules)){

            $this->db->beginTransaction();
            
                $images = glob(MY_PLAYLIST_DEFAULT_IMAGES . '/*.jpeg');
                $imageSource = $images[rand(0,4)];
                
                $result = $this->query("SELECT count(name) FROM $this->table WHERE name = :name", 
                [
                    'name' => $username
                ]);
                $counter = $result->fetchColumn();
                $counter = $counter === 0 ? '' : "-$counter";

                $result = $this->query("INSERT INTO $this->table (`user_id`, name, profile_picture) VALUES (:user_id, :name, :profile_picture)",
                [
                    'user_id' => $user_id,
                    'name' => $username . $counter,
                    'profile_picture' => $imageSource,
                ]);

            $this->db->commit();
            
            return $result;
        }       
        
    }

    public function openArtist($artist_id){
        // die(var_dump($user_id));
        if($this->validate(['id' => $artist_id],$this->rules())){

            $result = $this->query("SELECT * FROM $this->table WHERE (id = :id)",
            [
                'id' => $artist_id,

            ])->fetch(\PDO::FETCH_ASSOC);
            
            return $result;
        }
        
    }

    public function updateArtist(array $datas,$files){

        if($this->validate($datas,$this->rules())){

            if(!empty($files) && ($files['updateArtistPicture']['size'] > 0)){
                $extension = pathinfo($_FILES['updateArtistPicture']['name'], PATHINFO_EXTENSION);
                $fileName = $datas['updateArtistId'] . '-artist-picture';
                $uploadDir = ".." . MY_RELATIVE_PATH_TO_ARTIST_IMAGE;
                $uploadFile = $uploadDir . $fileName . '.'.$extension;
        
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                array_map('unlink', glob($uploadDir . $fileName . '.*'));
                move_uploaded_file($_FILES['updateArtistPicture']['tmp_name'], $uploadFile);
        
                $this->query("UPDATE $this->table SET profile_picture = :profile_picture WHERE id = :id",
                [
                    'profile_picture' => $uploadFile,
                    'id' => $datas['updateArtistId']
                ]);
        
            }
            
            $result = $this->query("UPDATE $this->table SET name = :name, `description` = :description, updated_at = NOW() WHERE id = :id",
            [
                'name' => $datas['updateArtistName'],
                'description' => $datas['updateArtistDescription'],
                'id'=> $datas['updateArtistId']
            ]);

            if ($result !== 0){

                $result = $this->query("SELECT * FROM $this->table WHERE id = :id",
                [
                    'id'=> $datas['updateArtistId'],
                ])->fetch(\PDO::FETCH_ASSOC);
                return $result;

            }
        }
    }
    
    public function showArtists () {

        $result = $this->query("SELECT name, description, id, profile_picture FROM $this->table ORDER BY RAND() LIMIT 5")->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMyArtistId($user_id){
        $result = $this->query("SELECT id FROM $this->table WHERE `user_id` = :user_id",
        [
            'user_id' => $user_id
        ])->fetch(\PDO::FETCH_ASSOC);
        return $result['id'];
    }

    public function dropMyArtist($artist_id) {
        $result = $this->query("DELETE FROM $this->table WHERE id = :id",
        [
            'id' => $artist_id,
        ]);
        return $result;
    }
}