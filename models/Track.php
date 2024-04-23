<?php
namespace myspotifyV2\models;

use myspotifyV2\dependencies\MyModel;
use myspotifyV2\models\PlaylistTrackRelation;


require_once '../dependencies/MyModel.php';
require_once '../models/PlaylistTrackRelation.php';
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

    public function createTrack(array $trackDatas, $artist_id){

        if($this->validate($trackDatas,$this->rules())){
            $ok = 2;
            $result = $this->query("INSERT INTO $this->table (title, duration, audio_link, category_id, artist_id) VALUES (:title, :duration, :audio_link, :category_id, :artist_id)",
            [
                'title' => $trackDatas['createTrackTitle'],
                'duration' => $trackDatas['createTrackDuration'],
                'audio_link' => $trackDatas['createTrackLink'],
                'artist_id' => $artist_id,
                'category_id' => $ok,
            ]);
            // die(var_dump($result));
            if(!$result){
                throw new \Exception('error sql');
            }
            return $result;
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