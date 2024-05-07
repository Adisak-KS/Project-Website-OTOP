<?php
require_once("../db/connect.php");

$titlePage = "ลบข้อมูลช่องทางชำระเงิน";

// รับ id
if (isset($_POST["btn-del"])) {
    $pmId = $_POST["pm_id"];
    $_SESSION["pm_id"] = $pmId; // เก็บค่า ID ใน session


    try {
        $sql = "SELECT *
                FROM ot_payment
                WHERE pm_id = :pm_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pm_id", $pmId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} elseif (isset($_SESSION["pm_id"])) {
    $pmId = $_SESSION["pm_id"];

    try {
        $sql = "SELECT *
                FROM ot_payment
                WHERE pm_id = :pm_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pm_id", $pmId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location:payment_show.php");
}

// ไม่มีข้อมูลจาก Database
if (!$result) {
    header("Location:payment_show.php");
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
                <form id="form" action="payment_edit.php" method="post" enctype="multipart/form-data">
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
                                            <label class="form-label" for="pm_id">รหัสช่องทางชำระเงิน : </label>
                                            <input class="form-control" type="text" name="pm_id" value="<?php echo $result["pm_id"]; ?>" readonly>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pm_bank">ชื่อธนาคาร : </label>
                                            <input class="form-control" type="text" name="pm_bank" value="<?php echo $result["pm_bank"]; ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pm_name">ชื่อบัญชี : </label>
                                            <input class="form-control" type="text" name="pm_name" value="<?php echo $result["pm_name"]; ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pm_number">เลขบัญชี : </label>
                                            <input class="form-control" type="text" name="pm_number" value="<?php echo $result["pm_number"]; ?>" disabled>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="prd_show">การแสดงช่องทางชำระเงิน : </label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success" type="radio" id="show" name="pm_show" value="1" <?php if ($result["pm_show"] == "1") echo "checked"; ?> disabled>
                                                <label for="show" class="custom-control-label">แสดงช่องทางชำระเงิน</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <!-- หากการแสดงสินค่ามีค่า = 0 หรือ มีค่าไม่ใช่เลข 1 ให้ checked  -->
                                                <input class="custom-control-input custom-control-input-danger" type="radio" id="hide" name="pm_show" value="0" <?php if ($result["pm_show"] == "0" || $result["pm_show"] != "1") echo "checked"; ?> disabled>
                                                <label for="hide" class="custom-control-label">ไม่แสดงช่องทางชำระเงิน</label>
                                            </div>
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
                                            รูปภาพ QR Code
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pm_qrcode">รูปภาพ QR Code : </label>
                                            <br>
                                            <img class="mx-auto d-block border" style="width:300px; height:250px" id="pm_qrcode" name="pm_qrcode" src="../uploads/img_payment/<?php echo $result["pm_qrcode"]; ?>">
                                            <input class="form-control" type="hidden" name="pm_qrCode" value="<?php echo $result["pm_qrcode"]; ?>" readonly>
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
                                            <a href="payment_show.php" class="btn btn-secondary" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                ยกเลิก
                                            </a>
                                            <!-- ส่ง pm_id และ pm_qrcode  -->
                                            <a data-pm_id="<?php echo $result["pm_id"]; ?>" data-pm_qrcode="<?php echo $result["pm_qrcode"]; ?>" class="btn btn-danger btn-delete">
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
            let pmId = $(this).data('pm_id');
            let pmQrCode = $(this).data('pm_qrcode');

            deleteConfirm(pmId, pmQrCode);
        });


        function deleteConfirm(pmId, pmQrCode) {
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
                                url: 'payment_del.php',
                                type: 'POST',
                                data: {
                                    pm_id: pmId,
                                    pm_qrcode: pmQrCode
                                },
                            })
                            .done(function() {
                                // การลบสำเร็จ ทำการ redirect ไปยังหน้า payment_show.php
                                document.location.href = 'payment_show.php';
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