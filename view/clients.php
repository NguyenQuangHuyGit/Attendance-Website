<?php
    session_start();
    if(!isset($_SESSION['isLoginClient'])){
        header("Location: ../index.php");
    }
    include('../model/DB.php');
    include('../model/student.php');
    include('../model/courseclass.php');
    include('../model/attendance.php');
    $courseClassModel = new courseclass();
    $studentModel = new student();
    $attendanceModel = new attendance();
    $student = $studentModel->getStudentByUserId($_SESSION['isLoginClient']);
    $classes = $courseClassModel->getClassByStudentId($student['id']);
    $course_id = '';
    $isSuccess = '';
    $attendances = array();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['course'])){
            $course_id = $_POST['course'];
            $attendances = $attendanceModel->getAttandanceByIdCourseClassAndStudentId($course_id, $student['id']);
        }
        if(isset($_POST['status'])){
            $status = $_POST['status']; 
            $attID = $_POST['attandanceID'];
            $isSuccess = $attendanceModel->updateStatus($attID,$student['id'],$status);
        }
    }
?>
<?php include_once('../include/clientsite.php')?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Các lớp học phần tham gia</h1>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form action="" method="POST">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="course" class="col-sm-2 col-form-label">Lớp học phần:</label>
                                    <div class="col-sm-10">
                                        <select id="course" name="course" class="form-select" required>
                                            <option value="" disabled selected>Chọn lớp học phần</option>
                                                <?php foreach($classes as $class){ ?>
                                                    <option value="<?= $class['id']?>" <?=(($class['id'] == $course_id)? 'selected':'') ?> ><?= $class['name']?></option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Xem thông tin điểm danh</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php if($course_id){ ?>
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <form action="" method="POST">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Ngày</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Gửi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($attendances as $attendance) {?>
                                    <tr>
                                        <td>
                                            <?= $attendance['days']?>
                                            <br />
                                            <?= $attendance['time_begin']?> - <?= $attendance['time_end']?>
                                        </td>
                                        <td>Buổi học bình thường
                                            <input type="hidden" value="<?= $attendance['id']?>" name="attandanceID">
                                        </td>
                                        <td>
                                            <?php if($attendance['status'] == 'Chưa điểm danh') {?>
                                                <select id="status" class="form-select" name="status" required>
                                                    <option value="Chưa điểm danh" <?= (($attendance['status'] == 'Chưa điểm danh')?'selected':'')?> disabled>Chưa điểm danh</option>
                                                    <option value="Đi học" <?= (($attendance['status'] == 'Đi học')?'selected':'')?>>Đi học</option>
                                                    <option value="Vắng" <?= (($attendance['status'] == 'Vắng')?'selected':'')?>>Vắng</option>
                                                </select>
                                            <?php }else{ ?>
                                                    <p><?= $attendance['status']?></p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($attendance['status'] == 'Chưa điểm danh'){
                                                    if($currentDate <= $attendance['days'] and $currentTime <= $attendance['time_end']){
                                                        if($currentTime >= $attendance['time_begin'])
                                                            echo '<button type="submit" class="btn btn-primary">Gửi</button>';
                                                        else
                                                            echo '<p>Chưa đến giờ điểm danh</p>';
                                                    }else
                                                        echo '<p>Đã hết hạn điểm danh</p>';
                                                }else{
                                                    echo 'Đã lưu kết quả';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <?php if($isSuccess) {?>
                    <div class="alert alert-success col-5 offset-1 fade-in-out" role="alert">
                        Lưu trạng thái thành công!
                    </div>
                <?php }else if($isSuccess == 0) {?>
                    <div class="row alert alert-danger col-5 offset-1 fade-in-out" role="alert">
                        Có lỗi hoặc đã quá hạn điểm danh!
                    </div>
                <?php } else echo ''?>
            </div>
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