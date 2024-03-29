<?php


    class CreateTableArtists {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "CREATE TABLE IF NOT EXISTS artistss (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(100) NOT NULL UNIQUE,
                    email VARCHAR(150) NOT NULL UNIQUE,
                    `password` VARCHAR(255) NOT NULL,
                    profile_picture VARCHAR(255),
                    `description` TEXT,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    user_id INT NOT NULL UNIQUE,
                    FOREIGN KEY (user_id) REFERENCES userss(id) ON DELETE CASCADE ON UPDATE CASCADE
                )";

            $request = $this->db->prepare($sql);
            $request->execute();
            
        }
    }