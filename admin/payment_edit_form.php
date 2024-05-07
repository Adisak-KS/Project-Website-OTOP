<?php
require_once("../db/connect.php");

$titlePage = "แก้ไขข้อมูลช่องทางชำระเงิน";

// รับ id
if (isset($_POST["btn-edit"])) {
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
    } catch (PDOException $e) {
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
    } catch (PDOException $e) {
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
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
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
                                            <input class="form-control" type="text" name="pm_bank" value="<?php echo $result["pm_bank"]; ?>" placeholder="กรุณากรอก ชื่อธนาคาร">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pm_name">ชื่อบัญชี : </label>
                                            <input class="form-control" type="text" name="pm_name" value="<?php echo $result["pm_name"]; ?>" placeholder="กรุณากรอก ชื่อบัญชี">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pm_number">เลขบัญชี : </label>
                                            <input class="form-control" type="text" name="pm_number" value="<?php echo $result["pm_number"]; ?>" placeholder="กรุณากรอก เลขบัญชี">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="prd_show">การแสดงช่องทางชำระเงิน : </label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success" type="radio" id="show" name="pm_show" value="1" <?php if ($result["pm_show"] == "1") echo "checked"; ?>>
                                                <label for="show" class="custom-control-label">แสดงช่องทางชำระเงิน</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <!-- หากการแสดงสินค่ามีค่า = 0 หรือ มีค่าไม่ใช่เลข 1 ให้ checked  -->
                                                <input class="custom-control-input custom-control-input-danger" type="radio" id="hide" name="pm_show" value="0" <?php if ($result["pm_show"] == "0" || $result["pm_show"] != "1") echo "checked"; ?>>
                                                <label for="hide" class="custom-control-label">ไม่แสดงช่องทางชำระเงิน</label>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-6">
                                <div class="card card-warning pb-5">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            รูปภาพ QR Code
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pm_qrcode">รูปภาพ QR Code : </label>
                                            <br>
                                            <img class="mx-auto d-block border" style="width:300px; height:250px" id="pm_qrcode" name="pm_qrcode" src="../uploads/img_payment/<?php echo $result["pm_qrcode"]; ?>">
                                            <input class="form-control" type="hidden" name="pm_qrCode" value="<?php echo $result["pm_qrcode"]; ?>" readonly>
                                            <label class="form-label" for="pm_newQrCode"> รูปภาพ QR Code ใหม่ : </label>
                                            <input class="form-control" type="file" name="pm_newQrCode" id="pm_newQrCode" onchange="previewImage();">
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
                                            <a href="payment_show.php" class="btn btn-secondary" type="button">
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
            $('#form').validate({
                rules: {
                    pm_bank: {
                        required: true,
                        minlength: 2,
                        maxlength: 50
                    },
                    pm_name: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙\s]*$/,
                        minlength: 2,
                        maxlength: 50,
                    },
                    pm_number: {
                        required: true,
                        pattern: /^[0-9\s]*$/,
                        minlength: 2,
                        maxlength: 30,
                    },
                    pm_newQrCode: {
                        extension: "png|jpg|jpeg"
                    }
                },
                messages: {
                    pm_bank: {
                        required: "กรุณากรอก ชื่อธนาคาร ของท่าน",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    pm_name: {
                        required: "กรุณากรอก ชื่อบัญชี ของท่าน",
                        pattern: "มีได้เฉพาะ A-Z, a-z หรือ ก-ฮ เท่านั้น",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    pm_number: {
                        required: "กรุณากรอก เลขบัญชี ของท่าน",
                        pattern: "มีได้เฉพาะตัวเลข 0-9 เท่านั้น",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 30 ตัวอักษร"
                    },
                    pm_newQrCode: {
                        extension: "ต้องเป็นไฟล์ .png, .jpg, .jpeg เท่านั้น",
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

    <!-- แสดงตัวอย่างรูปภาพไฟล์ใหม่ -->
    <script>
        function previewImage() {
            const fileInput = document.getElementById('pm_newQrCode');
            const imgElement = document.getElementById('pm_qrcode');
            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imgElement.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        }
    </script>

</body>

</html>
<?php require_once("includes/sweetalert2.php"); ?>