<?php
$titlePage = "จัดการกับบัญชีของฉัน";

require_once("db/connect.php");


if (!isset($_SESSION["mem_id"])) {
    $_SESSION["error"] = "กรุณาดเข้าสู่ระบบก่อนใช้งาน";
    header("Location:login_form.php");
    exit();
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

        <h1 class="text-center text-white display-6">จัดการกับบัญชีของฉัน</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
            <li class="breadcrumb-item active text-white">จัดการกับบัญชีของฉัน</li>
        </ol>


    </div>

    <!-- Contact Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <a href="my_account_profile_edit_form.php">
                                    <div class="box border rounded shadow p-3 h-75 w-75 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-user-gear mr-2 fa-2x"></i>
                                        <p class="ms-3 mt-3 fs-6">จัดการข้อมูลส่วนตัว</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-4">
                                <a href="my_account_edit_form.php">
                                    <div class="box border rounded shadow p-3 h-75 w-75 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-envelope mr-2 fa-2x"></i>
                                        <p class="ms-3 mt-3 fs-6">จัดการข้อมูลบัญชี</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-4">
                                <a href="my_account_password_edit_form.php">
                                    <div class="box border rounded shadow p-3 h-75 w-75 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-key mr-2 fa-2x"></i>
                                        <p class="ms-3 mt-3 fs-6">จัดการรหัสผ่าน</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-4">
                                <a href="my_account_history.php">
                                    <div class="box border rounded shadow p-3 h-75 w-75 d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-bag-shopping mr-2 fa-2x"></i>
                                        <p class="ms-3 mt-3 fs-6">ประวัติการสั่งซื้อ</p>
                                    </div>
                                </a>
                            </div>
                        </div>
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
<?php require_once("includes/sweetalert2.php");?>