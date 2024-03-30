<?php
class CreateTableJohns {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $query = $this->db->prepare("CREATE TABLE IF NOT EXISTS  johns
                    (id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(100))");
        $query->execute();
        // TODO: Add your migration code here
    }
}