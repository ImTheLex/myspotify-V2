<?php
require_once '../dependencies/MyModel.php';
use myspotifyV2\dependencies\MyModel;
class John extends MyModel {


    protected $rules = ([
        'name'=>'required|min:3',
        'titre'=>'password|min:10'
    ]);

    public function createJohn($datas){
        try {   
            if($this->validate($datas,$this->rules)){
                var_dump($datas);
                $sql = $this->db->prepare("INSERT INTO $this->table (name,Titre) VALUES (:name,:titre)");
                $sql->execute([
                    'name'=>$datas[array_keys($datas)[0]],
                    'titre'=>$datas[array_keys($datas)[1]]
                ]);
            }else {
                throw new \Exception("The inputs do not match");
            }
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
$datas = ['Usnameee'=>"lo1Ol",'Usertitree'=>"Wo1IIIIopie"];
$newjohn->createJohn($datas);
