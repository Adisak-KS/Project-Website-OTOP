<?php

require_once("../db/connect.php");

$titlePage = "แก้ไขข้อมูลบัญชี";

if (isset($_SESSION['admin_id'])) {

    $admId =  $_SESSION['admin_id'];

    try {
        $sql = "SELECT adm_id, adm_username, adm_email
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
                <form id="form" action="my_acc_account_edit.php" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            ข้อมูลชื่อผู้ใช้
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <input class="form-control" type="hidden" name="adm_id" value="<?php echo $result["adm_id"]; ?>" readonly>

                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="adm_username">ชื่อผู้ใช้เดิม : </label>
                                            <input class="form-control" type="text" id="adm_username" name="adm_username" placeholder="กรุณากรอกชื่อผู้ใช้เดิม ของท่าน" value="<?php echo $result["adm_username"] ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="adm_newUsername">ชื่อผู้ใช้ใหม่ : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="adm_newUsername" placeholder="กรุณากรอกชื่อผู้ใช้ใหม่ ของท่าน">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-6">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            ข้อมูลอีเมล
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="adm_email">อีเมลเดิม : </label>
                                            <input class="form-control" type="text" id="adm_email" name="adm_email" placeholder="กรุณากรอกอีเมลเดิม ของท่าน" value="<?php echo $result["adm_email"] ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="adm_newEmail">อีเมลใหม่ : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="adm_newEmail" placeholder="กรุณากรอกอีเมลใหม่ ของท่าน">
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
                    adm_newUsername: {
                        pattern: /^[a-zA-Z0-9_]+$/,
                        minlength: 6,
                        maxlength: 20,
                        notEqualTo: "#adm_username"
                    },
                    adm_newEmail: {
                        email: true,
                        notEqualTo: "#adm_email"
                    }
                },
                messages: {
                    adm_newUsername: {
                        pattern: "ชื่อผู้ใช้ต้องประกอบด้วยตัวอักษร A-Z, a-z, 0-9 และ_เท่านั้น",
                        minlength: "ต้องมีอย่างน้อย 6 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร",
                        notEqualTo: "คุณกำลังกรอกชื่อผู้ใช้เดิม กรุณาเลือกชื่อผู้ใช้ใหม่"
                    },
                    adm_newEmail: {
                        email: "รูปแบบอีเมลไม่ถูกต้อง",
                        notEqualTo: "คุณกำลังกรอกอีเมลเดิม กรุณาเลือกอีเมลใหม่"
                    }
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
<?php require_once("includes/sweetalert2.php"); ?>  