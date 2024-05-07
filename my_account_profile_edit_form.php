<?php
$titlePage = "ข้อมูลส่วนตัว";

require_once("db/connect.php");


if (!isset($_SESSION["mem_id"])) {
    $_SESSION["error"] = "กรุณาดเข้าสู่ระบบก่อนใช้งาน";
    header("Location:login_form.php");
    exit();
}

// แสดงข้อมูลตาม IDdd
if (isset($_SESSION["mem_id"])) {
    $memId = $_SESSION["mem_id"];

    try {
        $sql = "SELECT mem_id, mem_fname, mem_lname, mem_profile 
                FROM ot_member
                WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOEXception $e) {
        echo $e->getMessage();
        return false;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("includes/head.php") ?>
</head>

<body>

    <?php require_once("includes/navbar.php") ?>

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">

        <h1 class="text-center text-white display-6">จัดการข้อมูลส่วนตัว</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="my_account_setting.php">จัดการข้อมูลส่วนตัวทั้งหมด</a></li>
            <li class="breadcrumb-item active text-white">จัดการข้อมูลส่วนตัว</li>
        </ol>


    </div>

    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <form id="form" action="my_account_profile_edit.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="mem_id" value="<?php echo $result["mem_id"]; ?>" readonly>
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group mt-3">
                                <label for="mem_fname">ชื่อ : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_fname" class="w-100 form-control border-0 py-3 mb-4" placeholder="ชื่อจริงของท่าน" value="<?php echo $result["mem_fname"]; ?>">
                            </div>
                            <div class="form-group mt-5">
                                <label for="mem_lname">นามสกุล : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_lname" class="w-100 form-control border-0 py-3 mb-4" placeholder="นามสกุลของท่าน" value="<?php echo $result["mem_lname"]; ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label" for="mem_id">รูปภาพผู้ใช้งาน : </label>
                                    <br>
                                    <img class="rounded-circle mx-auto d-block border" style="width:90px; height:90px" id="mem_profile" name="mem_profile" src="uploads/profile_member/<?php echo $result["mem_profile"]; ?>">
                                    <input class="form-control" type="hidden" name="mem_profile" value="<?php echo $result["mem_profile"]; ?>" readonly>
                                    <label class="form-label" for="mem_newProfile">รูปภาพผู้ใช้งานใหม่ : </label>
                                    <input class="form-control border-1 py-3 mb-4" type="file" name="mem_newProfile" id="mem_newProfile" onchange="previewImage()">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <div class="d-inline-block me-3">
                                <a href="my_account_setting.php" type="button" class="btn form-control py-3 bg-gray text-secondary me-5">ยกเลิก</a>
                            </div>
                            <div class="d-inline-block">
                                <button type="submit" name="btn-edit-profile" class="btn form-control border-secondary py-3 bg-white text-primary">ยืนยันการแก้ไข</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Contact End -->


        <!-- Footer Start -->
        <?php require_once("includes/footer.php") ?>
        <?php require_once("includes/vendor.php") ?>

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


        <script>
            $(function() {

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
</body>

</html>
<!-- Sweetalert2 แจ้งเตือนจาก php  -->

<!-- หากเกิด Error จากฝั่ง server  -->
<?php if (isset($_SESSION['error'])) { ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'ไม่สำเร็จ',
            text: '<?php echo $_SESSION['error']; ?>',
        });
    </script>
<?php unset($_SESSION['error']);
}
?>

<!-- หากเกิด Success จากฝั่ง server  -->
<?php if (isset($_SESSION['success'])) { ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ',
            text: '<?php echo $_SESSION['success']; ?>',
        });
    </script>
<?php unset($_SESSION['success']);
}
?>