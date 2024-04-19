<?php
class AlterTableModifyColumnDurationTracks {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $query = $this->db->prepare("ALTER TABLE tracks MODIFY COLUMN duration BIGINT NOT NULL DEFAULT 0");
        $query->execute();

    }
}