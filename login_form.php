<?php
$titlePage = "เข้าสู่ระบบ";

require_once("db/connect.php");

if(!empty($_SESSION["mem_id"])){
    header("Location: index.php");
}

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
                        <form id="form" action="login_chk.php" method="POST">
                            <h1 class="text-center my-3">เข้าสู่ระบบ</h1>
                            <div class="form-group mb-3">
                                <label for="">ชื่อผู้ใช้ หรือ อีเมล : </label><span class="text-danger">*</span>
                                <input type="text" name="mem_username" class="w-100 form-control border-0 py-3 mb-4" placeholder="ชื่อผู้ใช้ หรือ อีเมล ของท่าน">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">รหัสผ่าน :</label><span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="password" class="w-75 form-control border-0 py-3 mb-4" name="mem_password" placeholder="กรุณากรอกรหัสผ่าน">
                                    <button class="btn btn-outline-secondary password-toggle border-0 py-3 mb-4 bg-white" type="button">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <button type="submit" name="btn-login" class="w-100 btn form-control border-secondary py-3 bg-white text-primary">เข้าสู่ระบบ</button>
                            </div>
                            <p class="mt-3">คุณยังไม่มีสมาชิกใช่ไหม ?
                                <a href="register_form.php">สมัครสมาชิกที่นี่</a>
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

        <script>
            $(function() {
                $('#form').validate({
                    rules: {
                        mem_username: {
                            required: true,
                        },
                        mem_password: {
                            required: true,
                        },
                    },
                    messages: {
                        mem_username: {
                            required: "กรุณากรอก ชื่อผู้ใช้ หรืออีเมล ของท่าน",
                        },
                        mem_password: {
                            required: "กรุณากรอก รหัสผ่าน ของท่าน",
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
<?php require_once("includes/sweetalert2.php"); ?>