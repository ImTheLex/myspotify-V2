<?php
namespace myspotifyV2\models;
use myspotifyV2\dependencies\MyModel;

require_once $_SERVER['DOCUMENT_ROOT'] . '/dependencies/MyModel.php';

class PlaylistUserRelation extends MyModel {

    protected $rules = ([
        'playlist_id'=>'required',
        'user_id'=>'required'
    ]);
    // die(var_dump($this->table,$this->db,$user_id,playlist_id));


    /**
     * Will create a relation between a user and a playlist the user wishes to subscribe to.
     */
    public function createRelation($user_id,$playlist_id){

        $this->db->beginTransaction();
            $result = $this->query("INSERT INTO $this->table (playlist_id,user_id) VALUES (:playlist_id,:user_id)",
            [
                'playlist_id'=>$playlist_id,
                'user_id'=>$user_id
            ]);
        $this->db->commit();
        return $result;
    }
    /**
     * Va analyser les relations d'abonnement, sur base de l'id d'utilisateur.
     * Si l'id de l'utilisateur correspond à une entrée c'est qu'il est au moins abonné au playlist_id correspondant.
     * Et comme l'idéal serait de récupérer TOUTES les playlist ID on renvoie un tableau.
     */
    public function getRelatedSusbcribes(int $userid):array{
        $result = $this->query("SELECT playlist_id FROM $this->table WHERE (`user_id`= :user_id)",
        [
            'user_id'=> $userid
        ])->fetchAll(\PDO::FETCH_ASSOC);

        return $result;     
    }

}