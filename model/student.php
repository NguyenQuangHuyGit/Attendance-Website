<?php
    class student extends DB{
        public function __construct(){parent::__construct();}

        public function getStudentById($stuId){
            $sql = "select fullName, email from students where id=:id";
            $stmt = parent::pdo($sql,[':id'=>$stuId]);
            return $stmt->fetch();
        }

        public function getStudentByUserId($userId){
            $sql = "select students.id, fullName, students.email 
                    from students, users
                    where students.user_id = users.id and user_id = :id";
            $stmt = parent::pdo($sql, [':id'=>$userId]);
            return $stmt->fetch();
        }

        public function getStudentByClassId($idClass){
            $sql = "select student_id from classdetail where class_id = :id";
            $stmt = parent::pdo($sql,['id'=>$idClass]);
            return $stmt->fetchAll();
        }

        public function getStudentByAttendanceId($attID){
            $sql = "select attendancerecords.student_id, fullName, email, status
                    from attendancerecords 
                    inner join students ON students.ID = attendancerecords.student_id
                    where attendance_id = :att_id ";
            $stmt = parent::pdo($sql,[':att_id'=>$attID]);
            return $stmt->fetchAll();
        }

        public function getStudentStaticByStudentId($stuId){
            $sql = "SELECT 
                SUM(Case when STATUS = 'Đi học' then 1 ELSE 0 END) present_count,
                SUM(Case when STATUS = 'Vắng' OR STATUS = 'Chưa điểm danh' then 1 ELSE 0 END) absent_count,
                fullName, courseclass.name
                FROM students
                INNER JOIN classdetail ON students.id = classdetail.student_id
                INNER JOIN courseclass ON classdetail.class_id = courseclass.id
                INNER JOIN attendance ON courseclass.ID = attendance.id_courseClass
                INNER JOIN attendancerecords ON students.id = attendancerecords.student_id and attendance.ID = attendancerecords.attendance_id
                WHERE students.id = :id
                GROUP BY courseclass.name";
            $stmt = parent::pdo($sql,[':id'=>$stuId]);
            return $stmt->fetchAll();
        }
    }