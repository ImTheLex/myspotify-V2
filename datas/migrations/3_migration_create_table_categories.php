<?php


    class CreateTableCategories {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "CREATE TABLE IF NOT EXISTS categories (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(100) NOT NULL UNIQUE,
                    picture VARCHAR(255)
                )";

            $request = $this->db->prepare($sql);
            $request->execute();
            
        }
    }