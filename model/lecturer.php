<?php
    class lecturer extends DB{
        public function __construct(){parent::__construct();}

        public function getLecturerByUserId($userId){
            $sql = "select lecturers.id, fullName, lecturers.email 
                    from lecturers, users
                    where lecturers.user_id = users.id and user_id = :id";
            $stmt = parent::pdo($sql, [':id'=>$userId]);
            return $stmt->fetch();
        }
    }