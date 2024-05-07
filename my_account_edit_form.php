<?php
$titlePage = "ข้อมูลบัญชี";

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
        $sql = "SELECT mem_id, mem_username, mem_email 
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

        <h1 class="text-center text-white display-6">จัดการข้อมูลบัญชี</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="my_account_setting.php">จัดการข้อมูลส่วนตัวทั้งหมด</a></li>
            <li class="breadcrumb-item active text-white">จัดการข้อมูลบัญชี</li>
        </ol>


    </div>

    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <form id="form" action="my_account_edit.php" method="POST">
                    <input type="hidden" name="mem_id" value="<?php echo $result["mem_id"]; ?>" readonly>
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group mt-3">
                                <label for="mem_username">ชื่อผู้ใช้เดิม : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_username" id="mem_username" class="w-100 form-control border-0 py-3 mb-4" placeholder="ชื่อผู้ใข้ของท่าน" value="<?php echo $result["mem_username"]; ?>" disabled>
                            </div>
                            <div class="form-group mt-3">
                                <label for="mem_username">ชื่อผู้ใช้ใหม่ : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_newUsername" class="w-100 form-control border-0 py-3 mb-4" placeholder="ชื่อผู้ใข้ของท่าน">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mt-3">
                                <label for="mem_email">อีเมลเดิม : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_email" id="mem_email" class="w-100 form-control border-0 py-3 mb-4 bg-gray" placeholder="อีเมลของท่าน" value="<?php echo $result["mem_email"]; ?>" disabled>
                            </div>
                            <div class="form-group mt-3">
                                <label for="mem_email">อีเมลใหม่ : </label><span class="text-danger">*</span>
                                <input type="email" name="mem_newEmail" class="w-100 form-control border-0 py-3 mb-4 bg-gray" placeholder="อีเมลของท่าน">
                            </div>
                        </div>

                        <hr>
                        <div>
                            <div class="d-inline-block me-3">
                                <a href="my_account_setting.php" type="button" class="btn form-control py-3 bg-gray text-secondary me-5">ยกเลิก</a>
                            </div>
                            <div class="d-inline-block">
                                <button type="submit" name="btn-edit-account" class="btn form-control border-secondary py-3 bg-white text-primary">ยืนยันการแก้ไข</button>
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

        <script>
            $(function() {
                // $.validator.setDefaults({
                //     submitHandler: function() {
                //         alert("Form successful submitted!");
                //     }
                // });
                $('#form').validate({
                    rules: {
                        mem_newUsername: {
                            pattern: /^[a-zA-Z0-9_]+$/,
                            minlength: 6,
                            maxlength: 20,
                            notEqualTo: "#mem_username"
                        },
                        mem_newEmail: {
                            email: true,
                            notEqualTo: "#mem_email"
                        }
                    },
                    messages: {
                        mem_newUsername: {
                            pattern: "ชื่อผู้ใช้ต้องประกอบด้วยตัวอักษร A-Z, a-z, 0-9 และ_เท่านั้น",
                            minlength: "ต้องมีอย่างน้อย 6 ตัวอักษร",
                            maxlength: "ต้องไม่เกิน 20 ตัวอักษร",
                            notEqualTo: "คุณกำลังกรอกชื่อผู้ใช้เดิม กรุณาเลือกชื่อผู้ใช้ใหม่"
                        },
                        mem_newEmail: {
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