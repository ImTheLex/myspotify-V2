<?php


    class AlterTablePlaylists {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "ALTER TABLE playlists MODIFY COLUMN title VARCHAR(100) DEFAULT 'Ma Playlist'";

            $request = $this->db->prepare($sql);
            $request->execute();
            
        }
    }