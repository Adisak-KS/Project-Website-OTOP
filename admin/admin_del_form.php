<?php
require_once("../db/connect.php");
require_once("includes/verify_admin.php");


$titlePage = "ลบข้อมูลผู้ดูแลระบบ";

// รับ id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-del"])) {
    $admId = $_POST["adm_id"];
    $_SESSION["adm_id"] = $admId; // เก็บค่า ID ใน session

    try {
        $sql = "SELECT * 
                FROM ot_admin 
                WHERE adm_id = :adm_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":adm_id", $admId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
} elseif (isset($_SESSION["adm_id"])) {
    $admId = $_SESSION["adm_id"];
    try {
        $sql = "SELECT * 
                FROM ot_admin 
                WHERE adm_id = :adm_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":adm_id", $admId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location: admin_show.php");
    exit;
}

//ไม่มีข้อมูลให้กลับ
if (!$result) {
    header("Location: admin_show.php");
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
                <form>
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
                                            <label class="form-label" for="adm_id">รหัสผู้ดูแลระบบ : </label>
                                            <input class="form-control" type="text" name="adm_id" value="<?php echo $result["adm_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="adm_fname">ชื่อ : </label>
                                            <input class="form-control" type="text" name="adm_fname" value="<?php echo $result["adm_fname"] ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="adm_lname">นามสกุล : </label>
                                            <input class="form-control" type="text" name="adm_lname" value="<?php echo $result["adm_lname"] ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="adm_username">ชื่อผู้ใช้ : </label>
                                            <input class="form-control" type="text" name="adm_username" value="<?php echo $result["adm_username"]; ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="adm_email">อีเมล : </label>
                                            <input class="form-control" type="email" name="adm_email" value="<?php echo $result["adm_email"]; ?>" disabled>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-6">
                                <div class="card card-danger pb-5">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            รูปภาพผู้ใช้งาน
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="adm_id">รูปภาพผู้ใช้งาน : </label>
                                            <br>
                                            <img class="rounded-circle mx-auto d-block border" style="width:150px; height:150px" id="adm_profile" name="adm_profile" src="../uploads/profile_admin/<?php echo $result["adm_profile"]; ?>">
                                            <input class="form-control" type="hidden" name="adm_profile" value="<?php echo $result["adm_profile"]; ?>" readonly>
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
                                            <a href="admin_show.php" class="btn btn-secondary" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                ยกเลิก
                                            </a>
                                            <!-- ส่ง adm_id และ adm_profile  -->
                                            <?php if ($result["adm_id"] == 1) { ?>
                                                <button type="button" class="btn btn-danger" disabled>
                                                    <i class="fa-solid fa-trash"></i>
                                                    ลบข้อมูล
                                                </button>
                                            <?php } else { ?>
                                                <a data-adm_id="<?php echo $result["adm_id"]; ?>" data-adm_profile="<?php echo $result["adm_profile"]; ?>" class="btn btn-danger btn-delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                    ลบข้อมูล
                                                </a>
                                            <?php } ?>
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
        <!-- <?php require_once("includes/footer.php"); ?> -->
    </div>
    <!-- ./wrapper -->

    <!-- vendor  -->
    <?php require_once("includes/vendor.php"); ?>

    <script>
        $(".btn-delete").click(function(e) {
            e.preventDefault();
            let admId = $(this).data('adm_id');
            let admProfile = $(this).data('adm_profile');

            deleteConfirm(admId, admProfile);
        });

        function deleteConfirm(admId, admProfile) {
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
                                url: 'admin_del.php',
                                type: 'POST',
                                data: {
                                    adm_id: admId,
                                    adm_profile: admProfile
                                },
                            })
                            .done(function() {
                                // การลบสำเร็จ ทำการ redirect ไปยังหน้า admin_show.php
                                document.location.href = 'admin_show.php';
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