<?php
$titlePage = "สมัครสมาชิก";

require_once("db/connect.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("includes/head.php") ?>
</head>

<body>

    <?php require_once("includes/navbar.php") ?>\
    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-6">
                        <form id="form" action="register.php" method="POST">
                            <h1 class="text-center my-3">สมัครสมาชิก</h1>
                            <div class="form-group mb-3">
                                <label for="mem_fname">ชื่อ : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_fname" class="w-100 form-control border-0 py-3 mb-4" placeholder="ชื่อจริงของท่าน">
                            </div>
                            <div class="form-group mb-3">
                                <label for="mem_lname">นามสกุล : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_lname" class="w-100 form-control border-0 py-3 mb-4" placeholder="นามสกุลของท่าน">
                            </div>
                            <div class="form-group mb-3">
                                <label for="mem_username">ชื่อผู้ใช้ : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_username" class="w-100 form-control border-0 py-3 mb-4" placeholder="ชื่อผู้ใช้ของท่าน">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">รหัสผ่าน :</label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="password" id="mem_password" class="w-75 form-control border-0 py-3 mb-4" name="mem_password" placeholder="กรุณากรอกรหัสผ่าน">
                                    <button class="btn btn-outline-secondary password-toggle border-0 py-3 mb-4 bg-white" type="button">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">ยืนยันรหัสผ่าน :</label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="password" id="mem_confirmPassword" class="w-75 form-control border-0 py-3 mb-4" name="mem_confirmPassword" placeholder="กรุณากรอกรหัสผ่านอีกครั้ง">
                                    <button class="btn btn-outline-secondary password-toggle border-0 py-3 mb-4 bg-white" type="button">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="mem_email">อีเมล : </label><span class="text-danger">*</span>
                                <input type="email" name="mem_email" class="w-100 form-control border-0 py-3 mb-4" placeholder="อีเมลของท่าน">
                            </div>

                            <hr>
                            <div>
                                <button type="submit" name="btn-register" class="w-100 btn form-control border-secondary py-3 bg-white text-primary ">สมัครสมาชิก</button>
                            </div>
                            <p class="mt-3">คุณเป็นสมาชิกอยู่แล้วใช่ไหม ?
                                <a href="login_form.php">เข้าสู่ระบบที่นี่</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->


        <!-- Footer Start -->
        <?php require_once("includes/footer.php") ?>
        <?php require_once("includes/vendor.php") ?>

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
                        mem_username: {
                            required: true,
                            pattern: /^[a-zA-Z0-9_]+$/,
                            minlength: 6,
                            maxlength: 20,
                        },
                        mem_password: {
                            required: true,
                            minlength: 8,
                            maxlength: 20
                        },
                        mem_confirmPassword: {
                            required: true,
                            minlength: 8,
                            maxlength: 20,
                            equalTo: "#mem_password" // ต้องเหมือนกับค่าของ mem_password
                        },
                        mem_email: {
                            required: true,
                            email: true,
                        },
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
                        mem_username: {
                            required: "กรุณากรอก ชื่อผู้ใช้ ของท่าน",
                            pattern: "ชื่อผู้ใช้ต้องประกอบด้วยตัวอักษร A-Z, a-z, 0-9 และ_เท่านั้น",
                            minlength: "ต้องมีอย่างน้อย 6 ตัวอักษร",
                            maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                        },
                        mem_password: {
                            required: "กรุณากรอก รหัสผ่าน ของท่าน",
                            minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                            maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                        },
                        mem_confirmPassword: {
                            required: "กรุณา ยืนยันรหัสผ่าน ของท่าน",
                            minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                            maxlength: "ต้องไม่เกิน 20 ตัวอักษร",
                            equalTo: "รหัสผ่านไม่ตรงกัน"
                        },
                        mem_email: {
                            required: "กรุณากรอก อีเมล ของท่าน",
                            email: "รูปแบบอีเมลไม่ถูกต้อง"
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

</html>