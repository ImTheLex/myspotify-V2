<?php


    class CreateTableTickets {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "CREATE TABLE IF NOT EXISTS tickets (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    `subject` VARCHAR(150) NOT NULL,
                    `content`TEXT NOT NULL,
                    response TEXT,
                    `state` TINYINT DEFAULT 1 NOT NULL,
                    `is_read` BOOLEAN DEFAULT 0,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `user_id` INT NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
                )";

            $request = $this->db->prepare($sql);
            $result = $request->execute();
            return $result;
            
        }
    }