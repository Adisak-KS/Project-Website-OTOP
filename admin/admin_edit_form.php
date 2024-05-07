<?php
require_once("../db/connect.php");

$titlePage = "แก้ไขข้อมูลผู้ดูแลระบบ";

// รับ id
if (isset($_POST["btn-edit"]) && isset($_POST["adm_id"])) {
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
    } catch (Exception $e) {
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
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location: admin_show.php");
    exit;
}

if(!$result){
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
                <form id="form" action="admin_edit.php" method="post" enctype="multipart/form-data">
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
                                            <label class="form-label" for="adm_id">รหัสผู้ดูแลระบบ : </label>
                                            <input class="form-control" type="text" name="adm_id" value="<?php echo $result["adm_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="adm_fname">ชื่อ : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="adm_fname" placeholder="กรุณากรอกชื่อจริง ของท่าน" value="<?php echo $result["adm_fname"] ?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="adm_lname">นามสกุล : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="adm_lname" placeholder="กรุณากรอกนามสกุล ของท่าน" value="<?php echo $result["adm_lname"] ?>">
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
                                <div class="card card-warning pb-5">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            รูปภาพผู้ใช้งาน
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="adm_id">รูปภาพผู้ใช้งาน : </label>
                                            <br>
                                            <img class="rounded-circle mx-auto d-block border" style="width:150px; height:150px" id="adm_profile" name="adm_profile" src="../uploads/profile_admin/<?php echo $result["adm_profile"]; ?>">
                                            <input class="form-control" type="hidden" name="adm_profile" value="<?php echo $result["adm_profile"]; ?>" readonly>
                                            <label class="form-label" for="adm_id">รูปภาพผู้ใช้งานใหม่ : </label>
                                            <input class="form-control" type="file" name="adm_newProfile" id="adm_newProfile" onchange="previewImage()">
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
                                            <a href="admin_show.php" class="btn btn-secondary" type="button">
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
                    adm_fname: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙]+$/,
                        minlength: 2,
                        maxlength: 20
                    },
                    adm_lname: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙]+$/,
                        minlength: 2,
                        maxlength: 20
                    },
                    adm_newProfile: {
                        extension: "png|jpg|jpeg"
                    }
                },
                messages: {
                    adm_fname: {
                        required: "กรุณากรอก ชื่อจริง ของท่าน",
                        pattern: "ชื่อ ห้ามมีตัวเลข สัญลักษณ์ หรือเว้นวรรค",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                    },
                    adm_lname: {
                        required: "กรุณากรอก นามสกุล ของท่าน",
                        pattern: "นามสกุล ห้ามมีตัวเลข สัญลักษณ์ หรือเว้นวรรค",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                    },
                    adm_newProfile: {
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
            const fileInput = document.getElementById('adm_newProfile');
            const imgElement = document.getElementById('adm_profile');
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
<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php");
