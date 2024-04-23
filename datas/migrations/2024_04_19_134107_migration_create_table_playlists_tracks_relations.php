<?php


    class CreateTablePlaylistsTracksRelations {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "CREATE TABLE IF NOT EXISTS playlist_track_relations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    track_id INT NOT NULL,
                    playlist_id INT NOT NULL,
                    FOREIGN KEY (track_id) REFERENCES tracks(id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (playlist_id) REFERENCES playlists(id) ON DELETE CASCADE ON UPDATE CASCADE
                )";

            $request = $this->db->prepare($sql);
            $result = $request->execute();
            return $result;
            
        }
    }