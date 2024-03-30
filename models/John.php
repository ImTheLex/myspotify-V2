<?php
require_once '../dependencies/MyModel.php';
use myspotifyV2\dependencies\MyModel;
class John extends MyModel {

    protected $rules = ([
        'name'=>'required|min:3',
        'titre'=>'password'
    ]);

    public function createJohn($datas){

        try {   
            if($this->validate($datas)){
                $sql = $this->db->prepare("INSERT INTO $this->table (name) VALUES (:name)");
                $sql->execute([
                    'name'=>$datas['name']
                ]);
            };
        } catch (\Exception $e) {
            echo "Validation failed: " . $e->getMessage();
        } 
        
        
    }

    public function query($sql, $params = []) {
        $request = $this->db->prepare($sql);
        $request->execute($params);
        return $request;
    }

}

$newjohn = new John();
$datas = ['name'=>"lol",'titre'=>"oki"];
$newjohn->createJohn($datas);
