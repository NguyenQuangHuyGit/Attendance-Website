<?php 
    session_start();
    if(!isset($_SESSION['isLoginAdmin'])){
        header("Location: ../index.php");
    }
    include('../model/DB.php');
    include('../model/courseclass.php');
    include('../model/attendance.php');
    include('../model/student.php');
    include('../model/lecturer.php');
    $attendanceModel = new attendance();
    $courseClassModel = new courseclass();
    $lecturerModel = new lecturer();
    $studentModel = new student();
    $lecturer = $lecturerModel->getLecturerByUserId($_SESSION['isLoginAdmin']);
    $lecturerId = $lecturer['id'];
    $classes = $courseClassModel->getClassByLecturerId($lecturerId);
    $isSuccess = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $courseId = $_POST['course'];
        $students = $studentModel->getStudentByClassId($courseId);
        $date = $_POST['date'];
        $timeStart = $_POST['timeStart'];
        $timeEnd = $_POST['timeEnd'];
        $attendanceModel->insertAttendance($lecturerId,$date,$courseId,$timeStart,$timeEnd);
        $isSuccess = $attendanceModel->insertAttendanceRecord($students);
    }
    include('../include/adminsite.php'); 
?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Tạo Danh Mục Điểm Danh</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin</h3>
                                </div>

                                <form action="" method="POST">
                                    <div class="card-body">
                                        <!-- <div class="mb-3 row">
                                            <label for="year" class="col-sm-2 col-form-label">Năm học:</label>
                                            <div class="col-sm-10">
                                                <select id="year" name="year" class="form-select">
                                                    <option selected>Chọn năm học</option>
                                                    <option value="2021-2022">2021-2022</option>
                                                    <option value="2022-2023">2022-2023</option>
                                                    <option value="2023-2024">2023-2024</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="phase" class="col-sm-2 col-form-label">Học kỳ:</label>
                                            <div class="col-sm-10">
                                                <select id="phase" name="phase" class="form-select">
                                                    <option selected>Chọn học kỳ</option>
                                                    <option value="Học kỳ 1">Học kỳ 1</option>
                                                    <option value="Học kỳ 2">Học kỳ 2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="stage" class="col-sm-2 col-form-label">Giai đoạn:</label>
                                            <div class="col-sm-10">
                                                <select id="stage" name="stage" class="form-select">
                                                    <option selected>Chọn giai đoạn</option>
                                                    <option value="Giai đoạn 1">Giai đoạn 1</option>
                                                    <option value="Giai đoạn 2">Giai đoạn 2</option>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="mb-3 row">
                                            <label for="course" class="col-sm-2 col-form-label">Lớp học phần:</label>
                                            <div class="col-sm-10">
                                                <select id="course" name="course" class="form-select" required>
                                                    <option value="" disabled selected>Chọn lớp học phần</option>
                                                    <?php foreach($classes as $class){ ?>
                                                        <option value="<?= $class['id']?>"><?= $class['name']?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- <div class="mb-3 row">
                                            <label for="course" class="col-sm-2 col-form-label">Lớp học chi tiết:</label>
                                            <div class="col-sm-10">
                                                <select id="course" name="course" class="form-select">
                                                    <option selected>Lớp</option>
                                                    <option value="">62TH2.1</option>
                                                    <option value="">62TH2.2</option>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="mb-3 row">
                                            <label for="date" class="col-sm-2 col-form-label">Ngày:</label>
                                            <div class="col-sm-10">
                                                <input type="date" name="date" class="" id="date" value="<?=$currentDate?>">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="time" class="col-sm-2 col-form-label">Giờ bắt đầu:</label>
                                            <div class="col-sm-10">
                                                <input type="time" id="timeStart" name="timeStart" value="<?= $currentTime?>" required>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="time" class="col-sm-2 col-form-label">Giờ kết thúc:</label>
                                            <div class="col-sm-10">
                                                <input type="time" id="timeEnd" name="timeEnd" value="<?= $currentTime?>" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Tạo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if($isSuccess) {?>
                            <div class="alert alert-success col-5 offset-1 fade-in-out" role="alert">
                                Thêm phiên điểm danh mới thành công
                            </div>
                        <?php }else if($isSuccess == 0) {?>
                            <div class="row alert alert-danger col-5 offset-1 fade-in-out" role="alert">
                                Có lỗi xảy ra trong quá trình thực hiện!
                            </div>
                        <?php } else echo ''?>
                    </div>
                </div>
            </section>
        </div>

        <script src="../public/template/admin/plugins/jquery/jquery.min.js"></script>
        <script src="../public/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../public/template/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <script src="../public/template/admin/dist/js/adminlte.min.js"></script>
        <script>
            setTimeout(function() {
                var element = document.querySelector(".fade-in-out");
                element.classList.add("show");
            }, 200);
        </script>
</body>

</html>