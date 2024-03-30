<?php
require_once '../dependencies/MyModel.php';
use myspotifyV2\dependencies\MyModel;
class Peinture extends MyModel {

    public function createPeinture(){
        $sql = $this->db->prepare("INSERT INTO $this->table  (name) VALUES (:name)");
        $sql->execute([
            'name'=>'Pain-Ture'
        ]);
    }

}

$newjohn = new Peinture();
$newjohn->createPeinture();