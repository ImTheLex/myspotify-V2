<?php
namespace myspotifyV2\models;
use myspotifyV2\dependencies\MyModel;

require_once '../dependencies/MyModel.php';
class PlaylistTrackRelation extends MyModel {

    protected $rules = ([
        'field1'=>'required|min:3',
        'field2'=>'required|min:3'
    ]);

    public function createPlaylistTrackRelation($track_id, $playlist_id){

        if($this->checkPlaylistTrackRelation($track_id,$playlist_id) === false){

            $result = $this->query("INSERT INTO $this->table (track_id, playlist_id) VALUES (:track_id,:playlist_id)",
            [
                'track_id'=>$track_id,
                'playlist_id'=>$playlist_id
            ]);
            return $result;
        }
        throw new \Exception('relation_already_exists');
    }

    public function checkPlaylistTrackRelation($track_id,$playlist_id){
        $result = $this->query("SELECT * FROM $this->table WHERE (playlist_id = :playlist_id) AND (track_id = :track_id)",
        [
            'track_id'=>$track_id,
            'playlist_id'=>$playlist_id

        ])->fetchColumn();
        return $result;
    }
    public function getPlaylistTracksRelations($playlist_id){
        $result = $this->query("SELECT track_id FROM $this->table WHERE (playlist_id = :playlist_id)",
        [
            'playlist_id'=>$playlist_id
        ])->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}