<?php
namespace myspotifyV2\models;

use myspotifyV2\dependencies\MyModel;

require_once '../dependencies/MyModel.php';
class Track extends MyModel {

    protected $rules = ([
        'title'=>'required|min:3|max:100',
        'link'=>'required|min:6|max:190|audio',
        'category'=>'required|int'
    ]);

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

    public function getTracks($artist_id){

        $result = $this->query("SELECT * FROM  $this->table WHERE artist_id = :artist_id",
        [
            'artist_id' => $artist_id,
        ])->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
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