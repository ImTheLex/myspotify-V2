<?php
class AlterTableAddAudioLinkTracks {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function up() {
        $query = $this->db->prepare("ALTER TABLE tracks ADD COLUMN audio_link varchar(191) UNIQUE");
        $query->execute();

    }
}