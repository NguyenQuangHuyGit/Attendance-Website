<?php 
    session_start();
    if(!isset($_SESSION['isLoginClient'])){
        header("Location: ../index.php");
    }
    include('../model/DB.php');
    include('../model/student.php');
    $studentModel = new student();
    $student = $studentModel->getStudentByUserId($_SESSION['isLoginClient']);
    $studentStatis = $studentModel->getStudentStaticByStudentId($student['id']);
?>
<?php include('../include/clientsite.php')?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Thông tin tông hợp điểm danh cá nhân</h1>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-md-10 mx-auto">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Sinh viên</th>
                                <th>Lớp học phần</th>
                                <th>Số buổi đi học</th>
                                <th>Số buổi vắng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($studentStatis as $sts){?>
                                <tr>
                                    <td><?= $sts['fullName']?></td>
                                    <td><?= $sts['name']?></td>
                                    <td><?= $sts['present_count']?></td>
                                    <td><?= $sts['absent_count']?></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="../public/template/admin/plugins/jquery/jquery.min.js"></script>
        <script src="../public/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../public/template/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <script src="../public/template/admin/dist/js/adminlte.min.js"></script>

</body>

</html>