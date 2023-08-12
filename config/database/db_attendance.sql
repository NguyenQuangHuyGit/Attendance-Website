/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE IF NOT EXISTS `attendance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `days` date DEFAULT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `id_courseClass` int(11) DEFAULT NULL,
  `time_begin` time NOT NULL,
  `time_end` time NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_GV` (`lecturer_id`),
  KEY `id_courseClass` (`id_courseClass`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`ID`),
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`id_courseClass`) REFERENCES `courseclass` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `attendance` (`ID`, `days`, `lecturer_id`, `id_courseClass`, `time_begin`, `time_end`) VALUES
	(1, '2023-05-20', 1, 1, '13:00:00', '13:05:00'),
	(12, '2023-05-21', 1, 1, '01:43:00', '01:43:00'),
	(16, '2023-05-21', 4, 2, '23:01:00', '23:30:00');

CREATE TABLE IF NOT EXISTS `attendancerecords` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `attendance_id` (`attendance_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `attendancerecords_ibfk_1` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`ID`),
  CONSTRAINT `attendancerecords_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `attendancerecords` (`ID`, `attendance_id`, `student_id`, `status`) VALUES
	(1, 1, 1, 'Đi học'),
	(2, 1, 2, 'Đi học'),
	(3, 1, 3, 'Đi học'),
	(4, 1, 4, 'Đi học'),
	(5, 1, 5, 'Đi học'),
	(7, 12, 1, 'Vắng'),
	(8, 12, 2, 'Đi học'),
	(9, 12, 3, 'Vắng'),
	(10, 12, 4, 'Chưa điểm danh'),
	(11, 12, 5, 'Đi học'),
	(27, 16, 1, 'Đi học'),
	(28, 16, 3, 'Vắng'),
	(29, 16, 5, 'Chưa điểm danh');

CREATE TABLE IF NOT EXISTS `classdetail` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE,
  KEY `class_id` (`class_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `classdetail_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `courseclass` (`ID`),
  CONSTRAINT `classdetail_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `classdetail` (`ID`, `class_id`, `student_id`) VALUES
	(1, 1, 1),
	(4, 1, 2),
	(5, 1, 3),
	(6, 1, 4),
	(7, 1, 5),
	(8, 2, 1),
	(9, 2, 3),
	(10, 2, 5);

CREATE TABLE IF NOT EXISTS `courseclass` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `time_begin` date DEFAULT NULL,
  `time_end` date DEFAULT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `id_course` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_GV` (`lecturer_id`),
  KEY `id_course` (`id_course`),
  CONSTRAINT `courseclass_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`ID`),
  CONSTRAINT `courseclass_ibfk_2` FOREIGN KEY (`id_course`) REFERENCES `courses` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `courseclass` (`ID`, `name`, `time_begin`, `time_end`, `lecturer_id`, `id_course`) VALUES
	(1, 'Công nghệ Web-2-22(62TH2)', '2023-04-17', '2023-06-18', 1, 1),
	(2, 'Cấu trúc dữ liệu và giải thuật-2-22(62TH2)', '2023-04-17', '2023-06-18', 4, 3);

CREATE TABLE IF NOT EXISTS `courses` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `courseID` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `courses` (`ID`, `courseID`, `title`, `content`) VALUES
	(1, 'CSE485', 'Công Nghệ Web', 'Môn học này cung cấp cho sinh viên các kiến thức cơ sở nhất trong việc xây dựng một website.'),
	(2, 'CSE480', 'Phân tích và thiết kế hệ thống thông tin', 'Môn học này giúp sinh viên hiểu và áp dụng các phương pháp, kỹ thuật và công cụ để phân tích, thiết kế và triển khai các hệ thống thông tin.'),
	(3, 'CSE281', 'Cấu trúc dữ liệu và giải thuật', 'Môn học Cấu trúc dữ liệu và giải thuật tập trung vào việc nắm vững các khái niệm, kỹ thuật và công cụ để hiểu, thiết kế và triển khai cấu trúc dữ liệu và giải thuật trong lập trình.\r\n\r\n');

CREATE TABLE IF NOT EXISTS `lecturers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `lecturers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `lecturers` (`ID`, `fullName`, `email`, `phoneNumber`, `address`, `level`, `user_id`) VALUES
	(1, 'Kiều Tuấn Dũng', 'dungkt@gmail.com', '0985532328', 'Hà Nội', 'Tiến Sĩ', 1),
	(2, 'Nguyễn Văn Nam', 'namvn@gmail.com', '0986652368', 'Thái Bình', 'Tiến Sĩ', NULL),
	(3, 'Dương Thị Thu Trang', 'trangttd@gmail.com', '0985235226', 'Thái Nguyên', 'Tiến Sĩ', NULL),
	(4, 'Phạm Thị Anh', 'anhtp@gmail.com', '0952258623', 'Hòa Bình', 'Tiến Sĩ', 3),
	(5, 'Lý Thành Công', 'congtl@gmail.com', '0986236358', 'Nghệ An', 'Tiến Sĩ', NULL);

CREATE TABLE IF NOT EXISTS `level` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `create_at` date DEFAULT NULL,
  `update_at` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `level` (`ID`, `name`, `create_at`, `update_at`) VALUES
	(1, 'Admin', '2023-05-18', '2023-05-18'),
	(2, 'user', '2023-05-18', '2023-05-18');

CREATE TABLE IF NOT EXISTS `register` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `semester` varchar(50) NOT NULL,
  `stage` varchar(50) NOT NULL,
  `schoolYear` varchar(50) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_SV` (`student_id`),
  KEY `id_course` (`course_id`),
  CONSTRAINT `register_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`ID`),
  CONSTRAINT `register_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `register` (`ID`, `semester`, `stage`, `schoolYear`, `student_id`, `course_id`) VALUES
	(1, 'Học kỳ II', 'Giai đoạn 2', '2022-2023', 1, 1),
	(2, 'Học kỳ II', 'Giai đoạn 2', '2022-2023', 2, 1),
	(3, 'Học kỳ II', 'Giai đoạn 2', '2022-2023', 3, 1),
	(4, 'Học kỳ II', 'Giai đoạn 2', '2022-2023', 4, 1),
	(5, 'Học kỳ II', 'Giai đoạn 2', '2022-2023', 5, 1);

CREATE TABLE IF NOT EXISTS `students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(50) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `students` (`ID`, `fullName`, `gender`, `birthday`, `email`, `phoneNumber`, `address`, `user_id`) VALUES
	(1, 'Lê Văn Quân', 'Nam', '2002-05-02', 'quanlv@gmail.com', '0962358866', 'Hà Nội', 2),
	(2, 'Nguyễn Văn Thành', 'Nam', '2002-07-06', 'thanhnv@gmail.com', '0961258966', 'Vĩnh Phúc', 7),
	(3, 'Nguyễn Thị Oanh', 'Nữ', '2002-04-03', 'oanhtn@gmail.com', '09856625358', 'Hải Dương', 5),
	(4, 'Lý Văn Trường ', 'Nam', '2002-03-16', 'truonglv@gmail.com', '0986258666', 'Quảng Ninh', 4),
	(5, 'Lê Văn Thắng', 'Nam', '2002-08-08', 'thanglv@gmail.com', '0966259358', 'Cao Bằng', 6);

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `create_at` date DEFAULT NULL,
  `update_at` date DEFAULT NULL,
  `id_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_level` (`id_level`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`ID`, `name`, `email`, `password`, `phone`, `address`, `create_at`, `update_at`, `id_level`) VALUES
	(1, 'dungkt', 'dungkt@gmail.com', '123456', '0985532356', 'Hà Nội', '2023-05-19', '2023-05-19', 1),
	(2, 'quanlv', 'quanlv@gmail.com', '123456', '0985562258', 'Hà Nội', '2023-05-19', '2023-05-19', 2),
	(3, 'anhpt', 'anhpt@gmail.com', '123456', '0965468856', 'Hòa Bình', '2023-05-21', '2023-05-21', 1),
	(4, 'truonglv', 'truonglv@gmail.com', '123456', '0968452657', 'Quảng Ninh', '2023-05-21', '2023-05-21', 2),
	(5, 'oanhnt', 'oanhnt@gmail.com', '123456', '0968425891', 'Hải Dương', '2023-05-21', '2023-05-21', 2),
	(6, 'thanglv', 'thanglv@gmail.com', '123456', '0968513589', 'Cao Bằng', '2023-05-21', '2023-05-21', 2),
	(7, 'thanhnv', 'thanhnv@gmail.com', '123456', '0984254862', 'Vĩnh Phúc', '2023-05-21', '2023-05-21', 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
