<?php
namespace myspotifyV2\models;

use myspotifyV2\dependencies\MyModel;
use myspotifyV2\models\PlaylistTrackRelation;


require_once '../dependencies/MyModel.php';
require_once '../models/PlaylistTrackRelation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/myconfig.php';

class Track extends MyModel {

    private $relations;
    protected $rules = ([
        'title'=>'required|min:3|max:100',
        'link'=>'required|min:6|max:190|audio',
        'category'=>'required|int'
    ]);
    


    public function __construct() {
        parent::__construct();
        $relations = new PlaylistTrackRelation;
        $this->relations = $relations;
    }

    public function createTrack(array $trackDatas, $artist_id,$files){
            
        if($this->validate($trackDatas,$this->rules())){

            $insertedTrackId = $this->query("INSERT INTO $this->table (title, duration, audio_link, category_id, artist_id) VALUES (:title, :duration, :audio_link, :category_id, :artist_id)",
            [
                'title' => $trackDatas['createTrackTitle'],
                'duration' => $trackDatas['createTrackDuration'],
                'audio_link' => $trackDatas['createTrackLink'],
                'category_id' => $trackDatas['createTrackCategory'],
                'artist_id' => $artist_id,
            ]);

            if(!empty($files) && ($files['createTrackLinkFile']['size'] > 0)){
                $extension = pathinfo($_FILES['createTrackLinkFile']['name'], PATHINFO_EXTENSION);
                $fileName = $insertedTrackId . '-audio-link';
                $uploadDir = ".." . MY_RELATIVE_PATH_TO_TRACKS_AUDIO;
                $uploadFile = $uploadDir . $fileName . '.'.$extension;
    
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                array_map('unlink', glob($uploadDir . $fileName . '.*'));
                move_uploaded_file($_FILES['createTrackLinkFile']['tmp_name'], $uploadFile);
                $this->query("UPDATE $this->table SET audio_link = :audio_link WHERE id = :id",
                [
                    'audio_link'=> $uploadFile,
                    'id' => $insertedTrackId
                ]);
                $insertedTrackId = true;
            }
            // die(var_dump($result));
            if(!$insertedTrackId){
                throw new \Exception('error sql');
            }
            return $insertedTrackId;
        }
        
    }

    public function createTrackRelation($trackId,$playlistId){

        $relation = $this->relations->createPlaylistTrackRelation($trackId,$playlistId);
        return $relation;
    }
    public function getTracks($artist_id){

        $result = $this->query("SELECT * FROM  $this->table WHERE artist_id = :artist_id",
        [
            'artist_id' => $artist_id,
        ])->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function getPlaylistTrack($playlistId){

        $result = $this->query("SELECT * FROM  $this->table WHERE id = :artist_id",);

    }


   
    public function getPlaylistTracks($playlistId){
           
        $tracks_ids_results = $this->relations->getPlaylistTracksRelations($playlistId);
        if(!empty($tracks_ids_results)){


            $placeholders = implode(',', array_fill(0, count($tracks_ids_results), '?'));
            $query = "SELECT * FROM $this->table WHERE id IN ($placeholders)";
            $stmt = $this->db->prepare($query);

            foreach ($tracks_ids_results as $k => $id){
                $stmt->bindValue(($k+1), $id['track_id']);
            }
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;

        }
        return false;
    
    }  


    public function setDuration(string $audio_link, string $duration){
        
        if($this->validate(['link' => $audio_link, 'duration' => $duration],$this->rules())){

            $result = $this->query("UPDATE $this->table SET duration = :duration WHERE audio_link = :audio_link",
            [
                'duration' => $duration,
                'audio_link'=> $audio_link,
            ]);

            return $result;
        }
    }
}