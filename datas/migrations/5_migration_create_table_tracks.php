<?php


    class CreateTableTracks {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "CREATE TABLE IF NOT EXISTS trackss (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(100) NOT NULL,
                    duration INT NOT NULL,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    artist_id INT NOT NULL,
                    category_id INT NOT NULL,
                    FOREIGN KEY (artist_id) REFERENCES artistss(id) ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (category_id) REFERENCES categoriess(id) ON DELETE CASCADE ON UPDATE CASCADE
                )";

            $request = $this->db->prepare($sql);
            $request->execute();
            
        }
    }