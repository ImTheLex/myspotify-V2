<?php

namespace myspotifyV2\dependencies;

class DatabaseConnection {
    // On défini comme private les infos de notre db.
    private $pdo;

    // A l'appel d'instanciation de DatabaseConnection, on execute ce code.
    public function __construct() {

        // Si la connexion echoue, tenter avec $server['documentroot']. J'effectue une connexion à la meme instance pdo via myartisan mais si le serveur "n'existe pas $server echouera. D'ou le _dir_. Maintenant je reste sceptique au regard de la synthaxe ci dessous.

        // $envFile = $_SERVER['DOCUMENT_ROOT'] .'/.env';
        $envFile2 =  dirname(__DIR__) . '../.env';        

        $envVariables = parse_ini_file($envFile2);

        if(!$envVariables){
            // $envVariables = parse_ini_file($envFile2);
        }

        $dsn = 'mysql:host=' . $envVariables['DB_HOST']. ';dbname=' . $envVariables['DB_NAME'];
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_PERSISTENT => true,
        ];

        if (isset($envVariables['DB_ENGINE']) && !empty($envVariables['DB_ENGINE'])) {
            $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET default_storage_engine={$envVariables['DB_ENGINE']}";
        }
    
        try {

            $this->pdo = new \PDO($dsn, $envVariables['DB_USER'], $envVariables['DB_PASS'], $options);

        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function get_pdo() {
        return $this->pdo;
    }
}
?>
