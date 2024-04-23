<?php
class AlterTableArtists {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $query = $this->db->prepare("ALTER TABLE artists MODIFY description TEXT NOT NULL");
        $result = $query->execute();
        return $result;


    }
}