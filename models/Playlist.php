<?php
namespace myspotifyV2\models;

use Exception;
use myspotifyV2\dependencies\MyModel;
use myspotifyV2\models\PlaylistUserRelation;

require_once $_SERVER['DOCUMENT_ROOT'] . '/dependencies/MyModel.php';
require_once  $_SERVER['DOCUMENT_ROOT'] . '/models/PlaylistUserRelation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/myconfig.php';



class Playlist extends MyModel {

    private $relations;

    protected $rules = ([
        'id'=>'required|int',
        'title'=>'required|min:3|max:25',
        'img'=>'required',
        'description'=>'required|min:3|max:50',
        'privacy'=>'required',
        'user_id'=>'required|int',
    ]);
        // die(var_dump($this->table,$this->db));

    public function __construct() {
        parent::__construct();
        $relations = new PlaylistUserRelation();
        $this->relations = $relations;
    }

    public function createPlaylist($user_id){

        if($this->validate(['user_id'=> $user_id],$this->rules)){

            $this->db->beginTransaction();
            
                $images = glob(MY_PLAYLIST_DEFAULT_IMAGES . '/*.jpeg');
                $imageSource = $images[rand(0,4)];
                
                $result = $this->query("SELECT count(id) FROM $this->table WHERE user_id = :user_id",
                [
                    'user_id' => $user_id,
                ]);
                $counter = $result->fetchColumn();
                
                $result = $this->query("INSERT INTO $this->table (`user_id`,title,img) VALUES (:user_id,:title,:img)",
                [
                    'user_id' => $user_id,
                    'title' => "Ma playlist N°$counter",
                    'img' => $imageSource,
                ]);

            $this->db->commit();
            
            if($result){
                $this->relations->createRelation($user_id,$result);
                return $result;
            }
        }       
        
    }

    public function openPlaylist($playlist_id,$user_id){

        if($this->validate(['id' => $playlist_id],$this->rules())){

            $result = $this->query("SELECT * FROM $this->table WHERE (id = :id) AND (privacy = 1 OR id IN (SELECT playlist_id FROM playlist_user_relations WHERE user_id = :user_id))",
            [
                'id' => $playlist_id,
                'user_id' => $user_id,

            ])->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }

    }

    public function getMyPlaylistRelations($user_id){
           
        $playlists_ids_results = $this->relations->getRelatedSusbcribes($user_id);
        if(!empty($playlists_ids_results)){

            $placeholders = implode(',', array_fill(0, count($playlists_ids_results), '?'));
            $query = "SELECT p.id, p.`user_id`, p.title, p.img, u.username AS creator 
                FROM $this->table AS p
                INNER JOIN users AS u ON p.user_id = u.id
                WHERE p.id IN ($placeholders)";
            $stmt = $this->db->prepare($query);

            foreach ($playlists_ids_results as $k => $id){
                $stmt->bindValue(($k+1), $id['playlist_id']);
            }
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;

        }
        return false;
    
    }  

    public function showPublicPlaylists(){
        $result = $this->query("SELECT p.id, p.user_id, p.img, p.title, u.username AS creator 
            FROM $this->table AS p
            INNER JOIN users AS u ON p.user_id = u.id
            WHERE privacy = 1 ORDER BY RAND() LIMIT 5")->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function deletePlaylist($playlist_id) {

        $result = $this->query("DELETE FROM $this->table WHERE id = :id",
        [
            'id'=> $playlist_id
        ]);
        return $result;
    
    }

    public function updatePlaylist(array $datas,$files){

        if($this->validate($datas,$this->rules())){

            if(!empty($files) && ($files['updatePlaylistPicture']['size'] > 0)){
                $extension = pathinfo($_FILES['updatePlaylistPicture']['name'], PATHINFO_EXTENSION);
                $fileName = $datas['updatePlaylstId'] . '-playlist-picture';
                $uploadDir = ".." . MY_RELATIVE_PATH_TO_PLAYLIST_IMAGE;
                $uploadFile = $uploadDir . $fileName . '.'.$extension;
        
                array_map('unlink', glob($uploadDir . $fileName . '.*'));
                move_uploaded_file($_FILES['updatePlaylistPicture']['tmp_name'], $uploadFile);
        
                $this->query("UPDATE $this->table SET img = :img WHERE id = :id",
                [
                    'img' => $uploadFile,
                    'id' => $datas['updatePlaylstId']
                ]);
        
            }
            
            $result = $this->query("UPDATE $this->table SET title = :title, `description` = :description, privacy = :privacy, updated_at = NOW() WHERE id = :id",
            [
                'title' => $datas['updatePlaylistTitle'],
                'description' => $datas['updatePlaylistDescription'],
                'privacy'=> $datas['updatePlaylistPrivacy'],
                'id'=> $datas['updatePlaylstId']
            ]);

            if ($result !== 0){

                $result = $this->query("SELECT title,`description`, img, privacy, id, `user_id` FROM playlists WHERE id = :id",
                [
                    'id'=> $datas['updatePlaylstId'],
                ])->fetch(\PDO::FETCH_ASSOC);
                return $result;

            }
        }
    }
}