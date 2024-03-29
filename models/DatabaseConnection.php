<?php
class DatabaseConnection {
    // On défini comme private les infos de notre db.
    private $pdo;

    // A l'appel d'instanciation de DatabaseConnection, on execute ce code.
    public function __construct() {

        $envFile = __DIR__ . '../../.env';

        $envVariables = parse_ini_file($envFile);

        $dsn = 'mysql:host=' . $envVariables['DB_HOST']. ';dbname=' . $envVariables['DB_NAME'];
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        if (isset($envVariables['DB_ENGINE']) && !empty($envVariables['DB_ENGINE'])) {
            $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET default_storage_engine={$envVariables['DB_ENGINE']}";
        }
    
        try {
            $this->pdo = new PDO($dsn, $envVariables['DB_USER'], $envVariables['DB_PASS'], $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function get_pdo() {
        return $this->pdo;
    }

    public function query($sql, $params = []) {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }
}
?>
