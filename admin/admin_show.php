<?php
require_once("../db/connect.php");
$titlePage = "ผู้ดูแลระบบ";

// แสดงข้อมูล Admin
try {
    $sql = "SELECT * FROM ot_admin";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage();
    return false;
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title mr-1">ข้อมูลผู้ดูแลระบบทั้งหมด</h3>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fa-regular fa-square-plus"></i>
                                        <span>เพิ่มผู้ดูแลระบบ</span>
                                    </button>


                                    <!-- Modal เพิ่มข้อมูล Admin -->
                                    <form id="form" action="admin_add.php" method="POST">
                                        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">เพิ่มผู้ดูแลระบบใหม่</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="adm_fname">ชื่อ : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="adm_fname" placeholder="กรุณากรอกชื่อจริง ของท่าน">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="adm_lname">นามสกุล : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="adm_lname" placeholder="กรุณากรอกนามสกุล ของท่าน">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="adm_username">ชื่อผู้ใช้ : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="adm_username" placeholder="กรุณากรอกชื่อผู้ใช้ ของท่าน">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="adm_password" class="form-label">รหัสผ่าน<span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control" name="adm_password" id="adm_password" placeholder="กรุณากรอกรหัสผ่าน">
                                                                <button class="btn btn-outline-secondary password-toggle" type="button">
                                                                    <i class="fa-solid fa-eye-slash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="adm_confirmPassword" class="form-label">ยืนยันรหัสผ่าน<span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control" name="adm_confirmPassword" id="adm_confirmPassword" placeholder="กรุณากรอกรหัสผ่าน">
                                                                <button class="btn btn-outline-secondary password-toggle" type="button">
                                                                    <i class="fa-solid fa-eye-slash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="adm_email">อีเมล : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="email" name="adm_email" placeholder="กรุณากรอกอีเมล ของท่าน">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fa-solid fa-xmark"></i>
                                                            ยกเลิก
                                                        </button>
                                                        <button type="submit" name="btn-add" class="btn btn-success">
                                                            <i class="fa-solid fa-floppy-disk"></i>
                                                            บันทึก
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Modal เพิ่มข้อมูล Admin End-->


                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php if (count($result) > 0) { ?>
                                        <table id="myTable" class="table table-bordered table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">รหัส</th>
                                                    <th class="text-center">รูปผู้ใช้</th>
                                                    <th class="text-center">ชื่อ</th>
                                                    <th class="text-center">นามสกุล</th>
                                                    <th class="text-center">ชื่อผู้ใช้</th>
                                                    <th class="text-center">อีเมล</th>
                                                    <th class="text-center">แก้ไขข้อมูล</th>
                                                    <th class="text-center">ลบข้อมูล</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $row) { ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $row["adm_id"] ?></td>
                                                        <td class="text-center">
                                                            <img class="rounded-circle border" style="width: 50px; height: 50px;" src="../uploads/profile_admin/<?php echo $row["adm_profile"]; ?>">
                                                        </td>
                                                        <td class="text-left"><?php echo $row["adm_fname"]; ?></td>
                                                        <td class="text-left"><?php echo $row["adm_lname"]; ?></td>
                                                        <td class="text-left"><?php echo $row["adm_username"]; ?></td>
                                                        <td class="text-left"><?php echo $row["adm_email"]; ?></td>
                                                        <td class="text-center">
                                                            <form method="post" action="admin_edit_form.php">
                                                                <input type="hidden" name="adm_id" value="<?php echo $row["adm_id"]; ?>">
                                                                <button type="submit" name="btn-edit" class="btn btn-warning">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                    <span>แก้ไข</span>
                                                                </button>
                                                            </form>
                                                        </td>

                                                        <td class="text-center">
                                                            <?php if ($row["adm_id"] === 1) { ?>
                                                                <button type="button"class="btn btn-danger" disabled>
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    <span>ลบ</span>
                                                                </button>
                                                            <?php } else { ?>
                                                                <form method="post" action="admin_del_form.php">
                                                                    <input type="hidden" name="adm_id" value="<?php echo $row["adm_id"]; ?>">
                                                                    <button type="submit" name="btn-del" class="btn btn-danger">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                        <span>ลบ</span>
                                                                    </button>
                                                                </form>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>

                                    <?php } else { ?>
                                        <!-- แสดง Alert เมื่อไม่มีข้อมูลใน Database  -->
                                        <?php require_once("includes/alert_no_data.php"); ?>
                                    <?php } ?>

                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
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
                    adm_username: {
                        required: true,
                        pattern: /^[a-zA-Z0-9_]+$/,
                        minlength: 6,
                        maxlength: 20,
                    },
                    adm_password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    adm_confirmPassword: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        equalTo: "#adm_password" // ต้องเหมือนกับค่าของ adm_password
                    },
                    adm_email: {
                        required: true,
                        email: true,
                    },
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
                    adm_username: {
                        required: "กรุณากรอก ชื่อผู้ใช้ ของท่าน",
                        pattern: "ชื่อผู้ใช้ต้องประกอบด้วยตัวอักษร A-Z, a-z, 0-9 และ_เท่านั้น",
                        minlength: "ต้องมีอย่างน้อย 6 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                    },
                    adm_password: {
                        required: "กรุณากรอก รหัสผ่าน ของท่าน",
                        minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร"
                    },
                    adm_confirmPassword: {
                        required: "กรุณา ยืนยันรหัสผ่าน ของท่าน",
                        minlength: "ต้องมีอย่างน้อย 8 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 20 ตัวอักษร",
                        equalTo: "รหัสผ่านไม่ตรงกัน"
                    },
                    adm_email: {
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

</html>

<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php"); ?>