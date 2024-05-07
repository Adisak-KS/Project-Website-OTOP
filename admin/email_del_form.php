<?php
require_once("../db/connect.php");


$titlePage = "ลบรายการติดต่อ";

// รับ id
if (isset($_POST["btn-edit"])) {
    $emId = $_POST["em_id"];
    $_SESSION["em_id"] = $emId; // เก็บค่า ID ใน session
    try {
        $sql = "SELECT * 
                    FROM ot_email 
                    WHERE em_id = :em_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":em_id", $emId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} elseif (isset($_SESSION["em_id"])) {
    $emId = $_SESSION["em_id"];
    try {
        $sql = "SELECT * 
                FROM ot_email 
                WHERE em_id = :em_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":em_id", $emId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location:email_show.php");
}

// ไม่มีข้อมูลจาก Database
if (!$result) {
    header("Location: email_show.php");
    exit;
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
                <form id="form" action="email_edit.php" method="post">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            ข้อมูลทั่วไป
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="em_id">รหัสรายการติดต่อ : </label>
                                            <input class="form-control" type="text" name="em_id" value="<?php echo $result["em_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="em_name">ชื่อ - นามสกุล : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="em_name" value="<?php echo $result["em_name"] ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="em_email">อีเมล: </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="em_email" value="<?php echo $result["em_email"] ?>" readonly>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="em_detail">รายละเอียด : </label><span class="text-danger">*</span>
                                            <textarea class="form-control" name="em_detail" rows="4" disabled><?php echo $result["em_detail"] ?></textarea>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="em_email">ตอบกลับ : </label><span class="text-danger">*</span>
                                            <a href="mailto:<?php echo $result["em_email"] ?>">ตอบกลับที่นี้</a>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="em_show">ประเภทสถานะ :</label><span class="text-danger">*</span>
                                            <div class="input-group">
                                                <select class="form-select" name="em_show" disabled>
                                                    <option value="">โปรดเลือกสถานะรายการ</option>
                                                    <option value="0" <?php echo ($result["em_show"] == 0) ? 'selected' : ''; ?>>ยังไม่ได้อ่าน</option>
                                                    <option value="1" <?php echo ($result["em_show"] == 1) ? 'selected' : ''; ?>>ตอบกลับแล้ว</option>
                                                    <option value="2" <?php echo ($result["em_show"] == 2) ? 'selected' : ''; ?>>น่าสงสัย</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>



                            <div class="col-md-12">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            จัดการข้อมูล
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <a href="email_show.php" class="btn btn-secondary" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                ยกเลิก
                                            </a>
                                            <a data-em_id="<?php echo $result["em_id"]; ?>" class="btn btn-danger btn-delete">
                                                <i class="fa-solid fa-trash"></i>
                                                ลบข้อมูล
                                            </a>
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
            $('#form').validate({
                rules: {
                    em_show: {
                        required: true,
                    },
                },
                messages: {
                    em_show: {
                        required: "กรุณาเลือกสถานะรายการติดต่อ",
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



    <script>
        $(".btn-delete").click(function(e) {
            e.preventDefault();
            let emId = $(this).data('em_id');

            deleteConfirm(emId);
        });

        function deleteConfirm(emId) {
            Swal.fire({
                icon: "warning",
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการลบข้อมูลนี้ใช่ไหม!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ใช่, ลบข้อมูลเลย!',
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'email_del.php',
                                type: 'POST',
                                data: {
                                    em_id: emId,
                                },
                            })
                            .done(function() {
                                // การลบสำเร็จ ทำการ redirect ไปยังหน้า admin_show.php
                                document.location.href = 'email_show.php';
                            })
                            .fail(function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ไม่สำเร็จ',
                                    text: 'เกิดข้อผิดพลาดที่ ajax !',
                                });
                            });
                    });
                },
            });
        }
    </script>

</body>

</html>
<?php require_once("includes/sweetalert2.php"); ?>