<?php
class CreateTableFlowsy {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $query = $this->db->prepare("CREATE TABLE IF NOT EXISTS flowsy 
                            (id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(100))");
        $result = $query->execute();
        return $result;


    }
}