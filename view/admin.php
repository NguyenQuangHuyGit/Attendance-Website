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
    $studentModel = new student();
    $lecturerModel = new lecturer();
    $lecturer = $lecturerModel->getLecturerByUserId($_SESSION['isLoginAdmin']);
    $lecturerId = $lecturer['id'];
    $classes = $courseClassModel->getClassByLecturerId($lecturerId);
    $course_id = '';
    $att_id = '';
    $date = '';
    $time = '';
    $students = array();
    $attendances = array();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $course_id = $_POST['course'];
        $attendances = $attendanceModel->getAttandanceByIdCourseClass($course_id);
    }
    if(isset($_GET['att'])){
        $att_id = $_GET['att'];
        $course_id = $_GET['course'];
        $date = $_GET['day'];
        $time = $_GET['time'];
        $students = $studentModel->getStudentByAttendanceId($att_id);
    }
?>
<?php include('../include/adminsite.php'); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Quản lý điểm danh</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin</h3>
                                </div>

                                <form method="post">
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
                                        </div> -->

                                        <!-- <div class="mb-3 row">
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
                                                            <option value="<?= $class['id']?>" <?=(($class['id'] == $course_id)? 'selected':'') ?> ><?= $class['name']?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-10">
                                                <h2><?=(($course_id)?'Danh sách các phiên điểm danh đã tạo':'Chọn lớp học phần để xem các phiên điểm danh')?></h2>
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        <?php foreach($attendances as $attendance) {?>
                                                            <tr>
                                                                <td style="width: 80%"><?= "Ngày tạo: {$attendance['days']} -- Giờ bắt đầu: {$attendance['time_begin']}"?></td>
                                                                <td style="width: 20%">
                                                                    <a href="./admin.php?att=<?= $attendance['id']?>&course=<?= $course_id?>&day=<?=$attendance['days']?>&time=<?=$attendance['time_begin']?>" class="btn btn-primary">
                                                                        Theo dõi
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- <div class="mb-3 row">
                                            <label for="date" class="col-sm-2 col-form-label">Ngày:</label>
                                            <div class="col-sm-10">
                                                <input type="date" name="date" class="" id="date">
                                            </div>
                                        </div> -->
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Xem</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php if(isset($_GET['att'])){ ?>                                                    
            <div class="row">
                <h2 class="text-center mt-4 mb-5 col-12">Bảng theo dõi điểm danh <?= (($att_id)?"ngày: $date giờ tạo: $time":'')?></h2>
            </div>

            <div class="row">
                
                <div class="col-md-10 mx-auto">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 10%">STT</th>
                                <th style="width: 30%">Tên</th>
                                <th style="width: 30%">Email</th>
                                <th style="width: 20%">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i = 0;$i<count($students);$i++){?>
                                <tr>
                                    <td><?= $i+1?></td>
                                    <td><?= $students[$i]['fullName']?></td>
                                    <td><?= $students[$i]['email']?></td>
                                    <td><?= $students[$i]['status']?></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php }?>
        </div>

        <script src="../public/template/admin/plugins/jquery/jquery.min.js"></script>
        <script src="../public/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../public/template/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <script src="../public/template/admin/dist/js/adminlte.min.js"></script>   

</body>

</html>