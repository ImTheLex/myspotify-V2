<?php


    class CreateTablePlaylistUserRelations {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "CREATE TABLE IF NOT EXISTS playlist_user_relations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT NOT NULL,
                    playlist_id INT NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (playlist_id) REFERENCES playlists(id) ON DELETE CASCADE ON UPDATE CASCADE
                )";

            $request = $this->db->prepare($sql);
            $result = $request->execute();
            return $result;
            
        }
    }