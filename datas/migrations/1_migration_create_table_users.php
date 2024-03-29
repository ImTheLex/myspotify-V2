<?php

class CreateTableUsers {


    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function up(){

        $sql = "CREATE TABLE IF NOT EXISTS userss (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) COLLATE utf8_bin NOT NULL UNIQUE,
                email VARCHAR(150) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                birth DATE NOT NULL,
                gender VARCHAR(50) NOT NULL,
                profile_picture VARCHAR(255),
                `role` TINYINT NOT NULL DEFAULT 1,
                logged_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                login_token VARCHAR(255),
                recover_token VARCHAR(255)
            )";

        $request = $this->db->prepare($sql);
        $request->execute();
    }
}