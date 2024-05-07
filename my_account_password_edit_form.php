<?php
$titlePage = "จัดการรหัสผ่าน";

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
        $sql = "SELECT mem_id, mem_password
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

        <h1 class="text-center text-white display-6">จัดการรหัสผ่าน</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="my_account_setting.php">จัดการข้อมูลส่วนตัวทั้งหมด</a></li>
            <li class="breadcrumb-item active text-white">จัดการรหัสผ่าน</li>
        </ol>


    </div>

    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <form id="form" action="my_account_password_edit.php" method="POST">
                    <input type="hidden" name="mem_id" value="<?php echo $result["mem_id"]; ?>" readonly>
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="">รหัสผ่านเดิม :</label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="password" name="mem_oldPassword" id="mem_oldPassword" class="w-75 form-control border-0 py-3 mb-4" placeholder="กรุณากรอกรหัสผ่านเดิม">
                                    <button class="btn btn-outline-secondary password-toggle border-0 py-3 mb-4 bg-white" type="button">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">รหัสผ่านใหม่ :</label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="password" name="mem_newPassword" id="mem_newPassword" class="w-75 form-control border-0 py-3 mb-4" name="mem_newPassword" placeholder="กรุณากรอกรหัสผ่านใหม่">
                                    <button class="btn btn-outline-secondary password-toggle border-0 py-3 mb-4 bg-white" type="button">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">ยืนยันรหัสผ่านใหม่ :</label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="password" id="mem_confirmNewPassword" class="w-75 form-control border-0 py-3 mb-4" name="mem_confirmNewPassword" placeholder="กรุณากรอกรหัสผ่านใหม่อีกครั้ง">
                                    <button class="btn btn-outline-secondary password-toggle border-0 py-3 mb-4 bg-white" type="button">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <div class="d-inline-block me-3">
                                <a href="my_account_setting.php" type="button" class="btn form-control py-3 bg-gray text-secondary me-5">ยกเลิก</a>
                            </div>
                            <div class="d-inline-block">
                                <button type="submit" name="btn-edit-password" class="btn form-control border-secondary py-3 bg-white text-primary">ยืนยันการแก้ไข</button>
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

        <!-- Show/Hidden Password  -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const passwordToggles = document.querySelectorAll('.password-toggle');

                passwordToggles.forEach(function(toggle) {
                    toggle.addEventListener('click', function() {
                        const passwordField = this.previousElementSibling;
                        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordField.setAttribute('type', type);

                        const icon = this.querySelector('i');
                        icon.classList.toggle('fa-eye-slash', type === 'password');
                        icon.classList.toggle('fa-eye', type !== 'password');
                    });
                });
            });
        </script>

        <!-- Validate Form -->
        <script>
            $(function() {
                $('#form').validate({
                    rules: {
                        mem_oldPassword: {
                            required: true,
                            minlength: 8,
                            maxlength: 20
                        },
                        mem_newPassword: {
                            required: true,
                            minlength: 8,
                            maxlength: 20,
                            notEqualTo: "#mem_oldPassword" // ต้องไม่เหมือนกับค่าของ mem_oldPassword
                        },
                        mem_confirmNewPassword: {
                            required: true,
                            minlength: 8,
                            maxlength: 20,
                            equalTo: "#mem_newPassword" // ต้องเหมือนกับค่าของ mem_password
                        },
                    },
                    messages: {
                        mem_oldPassword: {
                            required: "กรุณากรอก รหัสผ่าน ของท่าน",
                            minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                            maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                        },
                        mem_newPassword: {
                            required: "กรุณากรอก รหัสผ่านใหม่ ของท่าน",
                            minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                            maxlength: "ต้องไม่เกิน 20 ตัวอักษร",
                            notEqualTo: "กรุณาตั้งรหัสผ่านใหม่"
                        },
                        mem_confirmNewPassword: {
                            required: "กรุณา ยืนยันรหัสผ่าน ของท่าน",
                            minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                            maxlength: "ต้องไม่เกิน 20 ตัวอักษร",
                            equalTo: "รหัสผ่านไม่ตรงกัน"
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