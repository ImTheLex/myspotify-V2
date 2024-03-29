<?php


    class AlterTableUsers {

        private $db;


        public function __construct($db)
        {
            $this->db = $db;
        }


        public function up(){

            $sql = "ALTER TABLE users MODIFY username VARCHAR(190) COLLATE utf8_bin NOT NULL UNIQUE";

            $request = $this->db->prepare($sql);
            $request->execute();
            
        }
    }