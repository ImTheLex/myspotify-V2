<?php
namespace myspotifyV2\models;
use myspotifyV2\dependencies\MyModel;

require_once '../dependencies/MyModel.php';
class Track extends MyModel {

    protected $rules = ([
        'field1'=>'required|min:3',
        'field2'=>'required|min:3'
    ]);

    public function createTrack(){
        $request = $this->db->prepare("INSERT INTO $this->table (name) VALUES (:name)",
        [
            ['']
        ]);
    }


     /**
         * Crée une playlist et retourne l'id de cette dernière.
         */
        public function create_track($track_title, $duration, $artist_id):int{


            $request = $this->db->prepare("INSERT INTO tracks (title, duration, artist_id) VALUES (:title, :duration, :artist_id)");
            $request->bindValue(":title", $track_title);
            $request->bindValue(":duration", $duration);
            $request->bindValue(":artist_id", $artist_id);
            $request->execute();

            $lastTrack = $this->db->lastInsertId();

            return $lastTrack;
        }
}