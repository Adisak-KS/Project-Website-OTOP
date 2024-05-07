<?php
require_once("../db/connect.php");

$titlePage = "แสดงสมาชิก";

// แสดงข้อมูล Member
try {
    $sql = "SELECT * FROM ot_email";
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
                                    <h3 class="card-title mr-1">รายการที่ติดต่อทั้งหมด</h3>
                                </div>



                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php if (count($result) > 0) { ?>
                                        <table id="myTable" class="table table-bordered table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">รหัส</th>
                                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                                    <th class="text-center">อีเมล</th>
                                                    <th class="text-center">เวลาที่ส่ง</th>
                                                    <th class="text-center">สถานะ</th>
                                                    <th class="text-center">แก้ไขข้อมูล</th>
                                                    <th class="text-center">ลบข้อมูล</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $row) { ?>
                                                    <tr>


                                                        <td class="text-left"><?php echo $row["em_id"]; ?></td>
                                                        <td class="text-left"><?php echo $row["em_name"]; ?></td>
                                                        <td class="text-left"><?php echo $row["em_email"]; ?></td>
                                                        <td class="text-left"><?php echo $row["em_time"]; ?></td>
                                                        <td class="text-center">
                                                            <?php if ($row["em_show"] == 0) { ?>
                                                                <h5><span class='badge bg-danger'>ยังไม่อ่าน</span></h5>
                                                            <?php } elseif ($row["em_show"] == 1) { ?>
                                                                <h5><span class='badge bg-success'>ตอบกลับแล้ว</span></h5>
                                                            <?php } else { ?>
                                                                <h5><span class='badge bg-warning'>น่าสงสัย</span></h5>
                                                            <?php } ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <form method="post" action="email_edit_form.php">
                                                                <input type="hidden" name="em_id" value="<?php echo $row["em_id"]; ?>">
                                                                <button type="submit" name="btn-edit" class="btn btn-warning">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                    <span>แก้ไข</span>
                                                                </button>
                                                            </form>
                                                        </td>

                                                        <td class="text-center">
                                                            <form method="post" action="email_del_form.php">
                                                                <input type="hidden" name="em_id" value="<?php echo $row["em_id"]; ?>">
                                                                <button type="submit" name="btn-del" class="btn btn-danger">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    <span>ลบ</span>
                                                                </button>
                                                            </form>
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

</html>
<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php") ?>