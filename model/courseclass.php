<?php
    class courseclass extends DB{
        public function __construct(){parent::__construct();}

        public function getClassByLecturerId($lecId){
            $sql = "select id, name from courseclass where lecturer_id=:id";
            $stmt = parent::pdo($sql,[':id'=>$lecId]);
            return $stmt->fetchAll();
        }

        public function getClassByStudentId($stuId){
            $sql = "select courseclass.id, name 
                    from classdetail 
                    inner join courseclass on classdetail.class_id = courseclass.id
                    where student_id = :id";
            $stmt = parent::pdo($sql,[':id'=>$stuId]);
            return $stmt->fetchAll();
        }
        
        public function getStudentInClass($idClass){
            $sql = "select student_id from classdetail where class_id = :id";
            $stmt = parent::pdo($sql,['id'=>$idClass]);
            return $stmt->fetchAll();
        }
    }
?>