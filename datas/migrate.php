<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '../config/spotify_access.php';
    require '../models/DatabaseConnection.php';
    global $tracksDatas;
    $client = new DatabaseConnection();
    $db = $client->get_pdo();
  
// var_dump($client,$db);exit;


    function migrate($db) {

        $files = glob('migrations/*.php');

        var_dump($files);

        natsort($files);
        foreach($files as $file){

            require_once $file;
    
            $className = pathinfo($file,PATHINFO_FILENAME);
            var_dump($className);

            $className= preg_replace('/^\d+_migration_/','',$className);
            $className= str_replace('_',' ',$className);
            $className= ucwords($className);
            $className= str_replace(' ','',$className);
            
            $migration = new $className($db);
            $migration->up();
    
    
            echo "\n\nLa migration concernant " . $className . " a été effectuée." . PHP_EOL;
    
        }

    }
    

    migrate($db,$tracksDatas);