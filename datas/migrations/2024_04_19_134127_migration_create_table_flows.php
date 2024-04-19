<?php
class CreateTableFlows {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $request = $this->db->prepare("CREATE TABLE IF NOT EXISTS flows 
                            (id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(100))");
         $result = $request->execute();
         return $result;

    }
}