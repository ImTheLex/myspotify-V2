<?php
class AlterTableAddColumnSubjectTickets {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $query = $this->db->prepare("ALTER TABLE tickets ADD COLUMN `subject` VARCHAR(150) NOT NULL AFTER id");
        $query->execute();

    }
}