<?php

require_once("../db/connect.php");


$titlePage = "แก้ไขข้อมูลบัญชี";

if (isset($_SESSION['admin_id'])) {

    $admId =  $_SESSION['admin_id'];

    try {
        $sql = "SELECT adm_id, adm_password
                FROM ot_admin 
                WHERE adm_id = :adm_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":adm_id", $admId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("includes/head.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <?php //require_once("includes/preloader.php"); 
        ?>
        <!-- Navbar -->
        <?php require_once("includes/navbar.php"); ?>
        <!-- Main Sidebar Container -->
        <?php require_once("includes/main_sidebar.php"); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php require_once("includes/content_header.php"); ?>
            <!-- Main content -->
            <section class="content">
                <form id="form" action="my_acc_password_edit.php" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            ข้อมูลรหัสผ่าน
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <input class="form-control" type="hidden" name="adm_id" value="<?php echo $result["adm_id"]; ?>" readonly>
                                        <div class="form-group mb-3">
                                            <label for="adm_password" class="form-label">รหัสผ่านเดิม<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="adm_oldPassword" name="adm_oldPassword" placeholder="กรุณากรอกรหัสผ่านเดิม" maxlength="16">
                                                <button class="btn btn-outline-secondary password-toggle" type="button">
                                                    <i class="fa-solid fa-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="adm_password" class="form-label">รหัสผ่านใหม่<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="adm_password" name="adm_password" placeholder="กรุณากรอกรหัสผ่านใหม่" maxlength="16">
                                                <button class="btn btn-outline-secondary password-toggle" type="button">
                                                    <i class="fa-solid fa-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="adm_confirmPassword" class="form-label">ยืนยันรหัสผ่านใหม่<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="adm_confirmPassword" name="adm_confirmPassword" placeholder="กรุณากรอกรหัสผ่านใหม่ อีกครั้ง" maxlength="16">
                                                <button class="btn btn-outline-secondary password-toggle" type="button">
                                                    <i class="fa-solid fa-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-12">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            จัดการข้อมูล
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <a href="my_account_setting.php" class="btn btn-secondary" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                ยกเลิก
                                            </a>
                                            <button class="btn btn-warning" type="submit" name="btn-edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                บันทึกการแก้ไข
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Footer -->
        <?php require_once("includes/footer.php"); ?>
    </div>
    <!-- ./wrapper -->

    <!-- vendor  -->
    <?php require_once("includes/vendor.php"); ?>

    <!-- Show/Hidden Password  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggles = document.querySelectorAll('.password-toggle');

            passwordToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const passwordField = this.previousElementSibling;
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);

                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye-slash', type === 'password');
                    icon.classList.toggle('fa-eye', type !== 'password');
                });
            });
        });
    </script>



    <!-- Validate Form -->
    <script>
        $(function() {
            // $.validator.setDefaults({
            //     submitHandler: function() {
            //         alert("Form successful submitted!");
            //     }
            // });
            $('#form').validate({
                rules: {
                    adm_oldPassword: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    adm_password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        notEqualTo: "#adm_oldPassword" // ต้องไม่เหมือนกับค่าของ adm_oldPassword
                    },
                    adm_confirmPassword: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        equalTo: "#adm_password" // ต้องเหมือนกับค่าของ adm_password
                    },
                },
                messages: {
                    adm_oldPassword: {
                        required: "กรุณากรอก รหัสผ่าน ของท่าน",
                        minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                    },
                    adm_password: {
                        required: "กรุณากรอก รหัสผ่านใหม่ ของท่าน",
                        minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร",
                        notEqualTo: "กรุณาตั้งรหัสผ่านใหม่"
                    },
                    adm_confirmPassword: {
                        required: "กรุณา ยืนยันรหัสผ่าน ของท่าน",
                        minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร",
                        equalTo: "รหัสผ่านไม่ตรงกัน"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>
<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php");?>