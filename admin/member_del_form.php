<?php
require_once("../db/connect.php");


$titlePage = "ลบข้อมูลสมาชิก";

// รับ id
if (isset($_POST["btn-del"])) {
    $memId = $_POST["mem_id"];
    $_SESSION["mem_id"] = $memId; // เก็บค่า ID ใน session

    try {
        $sql = "SELECT * 
                FROM ot_member 
                WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
} elseif (isset($_SESSION["mem_id"])) {
    $memId = $_SESSION["mem_id"];
    try {
        $sql = "SELECT * 
                FROM ot_member 
                WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location: member_show.php");
}

// ไม่มีข้อมูลจาก Database
if (!$result) {
    header("Location: member_show.php");
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
                                            <label class="form-label" for="mem_id">รหัสผู้ดูแลระบบ : </label>
                                            <input class="form-control" type="text" name="mem_id" value="<?php echo $result["mem_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="mem_fname">ชื่อ : </label>
                                            <input class="form-control" type="text" name="mem_fname" value="<?php echo $result["mem_fname"] ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="mem_lname">นามสกุล : </label>
                                            <input class="form-control" type="text" name="mem_lname" value="<?php echo $result["mem_lname"] ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="mem_username">ชื่อผู้ใช้ : </label>
                                            <input class="form-control" type="text" name="mem_username" value="<?php echo $result["mem_username"]; ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="mem_email">อีเมล : </label>
                                            <input class="form-control" type="email" name="mem_email" value="<?php echo $result["mem_email"]; ?>" disabled>
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
                                            <label class="form-label" for="mem_id">รูปภาพผู้ใช้งาน : </label>
                                            <br>
                                            <img class="rounded-circle mx-auto d-block border" style="width:150px; height:150px" id="mem_profile" name="mem_profile" src="../uploads/profile_member/<?php echo $result["mem_profile"]; ?>">
                                            <input class="form-control" type="hidden" name="mem_profile" value="<?php echo $result["mem_profile"]; ?>" readonly>
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
                                            <a href="member_show.php" class="btn btn-secondary" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                ยกเลิก
                                            </a>
                                            <!-- ส่ง mem_id และ mem_profile  -->
                                            <a data-mem_id="<?php echo $result["mem_id"]; ?>" data-mem_profile="<?php echo $result["mem_profile"]; ?>" class="btn btn-danger btn-delete">
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

    <script>
        $(".btn-delete").click(function(e) {
            e.preventDefault();
            let memId = $(this).data('mem_id');
            let memProfile = $(this).data('mem_profile');

            deleteConfirm(memId, memProfile);
        });

        function deleteConfirm(memId, memProfile) {
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
                                url: 'member_del.php',
                                type: 'POST',
                                data: {
                                    mem_id: memId,
                                    mem_profile: memProfile
                                },
                            })
                            .done(function() {
                                // การลบสำเร็จ ทำการ redirect ไปยังหน้า member_show.php
                                document.location.href = 'member_show.php';
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