<?php
    class user extends DB{
        public function __construct(){parent::__construct();}
        public function getAll(){
            $sql = "select id, email, password, id_level from users";
            $stmt = parent::pdo($sql);
            return $stmt->fetchAll();
        }
    }