<?php
    class attendance extends DB{
        public function __construct(){parent::__construct();}

        public function getAttendanceById($attId){
            $sql = "select days, time_end from attendance where id = :id";
            $stmt = parent::pdo($sql,[':id'=>$attId]);
            return $stmt->fetch();
        }

        public function getAttandanceByIdCourseClass($idCourseClass){
            $sql = "select id, days, time_begin from attendance where id_courseClass = :id";
            $stmt = parent::pdo($sql,[':id'=>$idCourseClass]);
            return $stmt->fetchAll();
        }

        public function getAttandanceByIdCourseClassAndStudentId($idCourseClass, $stuId){
            $sql = "select attendance.id, days, time_begin, time_end, status 
                    from attendance
                    INNER JOIN attendancerecords ON attendance.ID = attendancerecords.attendance_id
                    where id_courseClass = :id1 AND student_id = :id2";
            $stmt = parent::pdo($sql,[':id1'=>$idCourseClass,':id2'=>$stuId]);
            return $stmt->fetchAll();
        }

        public function insertAttendance($lecturer_id, $date, $class_id, $timeStart, $timeEnd){
            $sql = "insert into attendance (`days`, `lecturer_id`, `id_courseClass`, `time_begin`, `time_end`) values (:day,:lecturer_id,:class_id,:timeStart,:timeEnd)";
            $array = ['day'=>$date, 'lecturer_id'=>$lecturer_id, 'class_id'=>$class_id, 'timeStart'=>$timeStart, 'timeEnd'=>$timeEnd];
            $stmt = parent::pdo($sql,$array);
        }

        public function insertAttendanceRecord($arrayStudent){
            $id = parent::getLastInsertId();
            $sql = "insert into attendancerecords (`attendance_id`, `student_id`, `status`) values (:att_id,:stu_id,:sts)";
            $stmt = parent::getStatement($sql);
            foreach($arrayStudent as $student){
                $stmt->bindParam(':att_id',$id);
                $stmt->bindParam(':stu_id',$student['student_id']);
                $stmt->bindValue(':sts','Chưa điểm danh');
                $stmt->execute();
            }
            if($stmt->rowCount() > 0)
                return $stmt->rowCount();
            else    
                return 0;
        }

        public function updateStatus($attID, $stuID, $status){
            $currentDate = Date("Y-m-d");
            $currentTime = Date("H:i");
            $attendance = $this->getAttendanceById($attID);
            $time = date('H:i', strtotime($attendance['time_end'].' +1 minute'));
            $sql = "update attendancerecords set status = :sts where attendance_id = :att_id and student_id = :stu_id";
            if($attendance['days'] >= $currentDate and $time >= $currentTime){
                $stmt = parent::pdo($sql,[':sts'=> $status, ':att_id'=>$attID, ':stu_id'=> $stuID]);
                return $stmt->rowCount();
            }
            return 0;
        }
        
    }
?>