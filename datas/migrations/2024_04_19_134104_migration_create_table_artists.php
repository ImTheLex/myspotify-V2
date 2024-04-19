<?php


    class CreateTableArtists {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "CREATE TABLE IF NOT EXISTS artists (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(100) NOT NULL UNIQUE,
                    profile_picture VARCHAR(255),
                    `description` TEXT,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    user_id INT NOT NULL UNIQUE,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
                )";

            $request = $this->db->prepare($sql);
            $result = $request->execute();
            return $result;
            
        }
    }