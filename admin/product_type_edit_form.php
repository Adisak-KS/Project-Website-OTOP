<?php
require_once("../db/connect.php");


$titlePage = "แก้ไขข้อมูลประเภทสินค้า";

// รับ id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-edit"])) {
        $ptyId = $_POST["pty_id"];
        $_SESSION["pty_id"] = $ptyId; // เก็บค่า ID ใน session
        try {
            $sql = "SELECT * 
                    FROM ot_product_type 
                    WHERE pty_id = :pty_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":pty_id", $ptyId);
            $stmt->execute();
            $result = $stmt->fetch();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
}elseif (isset($_SESSION["pty_id"])) {
    $ptyId = $_SESSION["pty_id"];
    try {
        $sql = "SELECT * 
                FROM ot_product_type 
                WHERE pty_id = :pty_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pty_id", $ptyId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}else{
    header("Location:product_type_show.php");
}

//ไม่มีข้อมูลให้กลับ
if (!$result) {
    header("Location:product_type_show.php");
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
                <form id="form" action="product_type_edit.php" method="post" enctype="multipart/form-data">
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
                                            <label class="form-label" for="pty_id">รหัสประเภทสินค้า : </label>
                                            <input class="form-control" type="text" name="pty_id" value="<?php echo $result["pty_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="pty_name">ชื่อประเภทสินค้า : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="pty_name" placeholder="กรุณากรอก ชื่อประเภทสินค้า" value="<?php echo $result["pty_name"] ?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pty_detail">รายละเอียด : </label><span class="text-danger">*</span>
                                            <textarea class="form-control" name="pty_detail" rows="4" placeholder="กรุณากรอก รายบะเอียดประเภทสินค้า"><?php echo $result["pty_detail"] ?></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="pty_show">การแสดงประเภทสินค้า : </label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success" type="radio" id="show" name="pty_show" value="1" <?php if ($result["pty_show"] == "1") echo "checked"; ?>>
                                                <label for="show" class="custom-control-label">แสดงประเภทสินค้า</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <!-- หากการแสดงสินค่ามีค่า = 0 หรือ มีค่าไม่ใช่เลข 1 ให้ checked  -->
                                                <input class="custom-control-input custom-control-input-danger" type="radio" id="hide" name="pty_show" value="0" <?php if ($result["pty_show"] == "0" || $result["pty_show"] != "1") echo "checked"; ?>>
                                                <label for="hide" class="custom-control-label">ไม่แสดงประเภทสินค้า</label>
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
                                            รูปภาพประเภทสินค้า
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pty_img">รูปภาพประเภทสินค้า : </label>
                                            <br>
                                            <img class="mx-auto d-block border" style="width:150px; height:150px" id="pty_img" name="pty_img" src="../uploads/img_product_type/<?php echo $result["pty_img"]; ?>">
                                            <input class="form-control" type="hidden" name="pty_img" value="<?php echo $result["pty_img"]; ?>" readonly>
                                            <label class="form-label" for="pty_img"> รูปภาพประเภทสินค้าใหม่ : </label>
                                            <input class="form-control" type="file" name="pty_newImg" id="pty_newImg" onchange="previewImage()">
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
                                            <a href="product_type_show.php" class="btn btn-secondary" type="button">
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
                    pty_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    pty_detail: {
                        required: true,
                        minlength: 2,
                        maxlength: 100
                    },
                    pty_newImg: {
                        extension: "png|jpg|jpeg"
                    }
                },
                messages: {
                    pty_name: {
                        required: "กรุณากรอก ชื่อประเภทสินค้า",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 30 ตัวอักษร"
                    },
                    pty_detail: {
                        required: "กรุณากรอก รายละเอียดประเภทสินค้า",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 100 ตัวอักษร"
                    },
                    pty_newImg: {
                        extension: "ต้องเป็นไฟล์ .png .jpg .jpeg เท่านั้น"
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
            const fileInput = document.getElementById('pty_newImg');
            const imgElement = document.getElementById('pty_img');
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