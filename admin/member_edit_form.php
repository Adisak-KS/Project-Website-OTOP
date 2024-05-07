<?php
require_once("../db/connect.php");
$titlePage = "แก้ไขข้อมูลสมาชิก";

// รับ id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-edit"])) {
    $memId = $_POST["mem_id"];
    $_SESSION["mem_id"] = $memId; // เก็บค่า ID ใน session

    try {
        $sql = "SELECT * FROM ot_member WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}elseif (isset($_SESSION["mem_id"])) {
    $memId = $_SESSION["mem_id"];
    try {
        $sql = "SELECT * FROM ot_member WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}else{
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
                <form id="form" action="member_edit.php" method="post" enctype="multipart/form-data">
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
                                            <label class="form-label" for="mem_id">รหัสสมาชิก : </label>
                                            <input class="form-control" type="text" name="mem_id" value="<?php echo $result["mem_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="mem_fname">ชื่อ : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="mem_fname" placeholder="กรุณากรอกชื่อจริง ของท่าน" value="<?php echo $result["mem_fname"] ?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="mem_lname">นามสกุล : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="mem_lname" placeholder="กรุณากรอกนามสกุล ของท่าน" value="<?php echo $result["mem_lname"] ?>">
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
                                <div class="card card-warning pb-5">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            รูปภาพผู้ใช้งาน
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="mem_id">รูปภาพผู้ใช้งาน : </label>
                                            <br>
                                            <img class="rounded-circle mx-auto d-block border" style="width:150px; height:150px" id="mem_profile" name="mem_profile" src="../uploads/profile_member/<?php echo $result["mem_profile"]; ?>">
                                            <input class="form-control" type="hidden" name="mem_profile" value="<?php echo $result["mem_profile"]; ?>" readonly>
                                            <label class="form-label" for="mem_id">รูปภาพผู้ใช้งานใหม่ : </label>
                                            <input class="form-control" type="file" name="mem_newProfile" id="mem_newProfile" onchange="previewImage()">
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
                                            <a href="member_show.php" class="btn btn-secondary" type="button">
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
                    mem_fname: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙]+$/,
                        minlength: 2,
                        maxlength: 20
                    },
                    mem_lname: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙]+$/,
                        minlength: 2,
                        maxlength: 20
                    },
                    mem_newProfile: {
                        extension: "png|jpg|jpeg"
                    }
                },
                messages: {
                    mem_fname: {
                        required: "กรุณากรอก ชื่อจริง ของท่าน",
                        pattern: "ชื่อ ห้ามมีตัวเลข สัญลักษณ์ หรือเว้นวรรค",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                    },
                    mem_lname: {
                        required: "กรุณากรอก นามสกุล ของท่าน",
                        pattern: "นามสกุล ห้ามมีตัวเลข สัญลักษณ์ หรือเว้นวรรค",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                    },
                    mem_newProfile: {
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
            const fileInput = document.getElementById('mem_newProfile');
            const imgElement = document.getElementById('mem_profile');
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
<?php require_once("includes/sweetalert2.php") ?>