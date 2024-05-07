<?php
require_once("../db/connect.php");
$titlePage = "ช่องทางชำระเงิน";

// แสดงข้อมูล Payment
try {
    $sql = "SELECT * FROM ot_payment";
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
                                    <h3 class="card-title mr-1">ข้อมูลช่องทางชำระเงินทั้งหมด</h3>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fa-regular fa-square-plus"></i>
                                        <span>เพิ่มช่องทางชำระเงิน</span>
                                    </button>


                                    <!-- Modal เพิ่มข้อมูล Payment -->
                                    <form id="form" action="payment_add.php" method="POST">
                                        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">เพิ่มช่องทางชำระเงินใหม่</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="pm_bank">ชื่อธนาคาร : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="pm_bank" placeholder="กรุณากรอกชื่อธนาคาร">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="pm_name">ชื่อบัญชี : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="pm_name" placeholder="กรุณากรอกชื่อบัญชี">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="pm_number">เลขบัญชี : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="pm_number" placeholder="กรุณากรอกเลขบัญชี">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="customRadio1">การแสดงช่องทางชำระเงิน : </label>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input custom-control-input-success" type="radio" id="customRadio1" name="prd_show" disabled>
                                                                <label for="customRadio1" class="custom-control-label">แสดงสินค้า</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio2" name="prd_show" checked>
                                                                <label for="customRadio2" class="custom-control-label">ไม่แสดงสินค้า</label>
                                                            </div>
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
                                    <!-- Modal เพิ่มข้อมูล Payment End-->


                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php if (count($result) > 0) { ?>
                                        <table id="myTable" class="table table-bordered table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">QR Code</th>
                                                    <th class="text-center">ธนาคาร</th>
                                                    <th class="text-center">ชื่อบัญชี</th>
                                                    <th class="text-center">เลขบัญชี</th>
                                                    <th class="text-center">สถานะ</th>
                                                    <th class="text-center">แก้ไขข้อมูล</th>
                                                    <th class="text-center">ลบข้อมูล</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $row) { ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $row["pm_id"] ?></td>
                                                        <td class="text-center">
                                                            <img class="rounded border" style="width: 50px; height: 50px;" src="../uploads/img_payment/<?php echo $row["pm_qrcode"]; ?>">
                                                        </td>
                                                        <td class="text-left"><?php echo $row["pm_name"]; ?></td>
                                                        <td class="text-left"><?php echo $row["pm_bank"]; ?></td>
                                                        <td class="text-left"><?php echo $row["pm_number"]; ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($row["pm_show"] == 0) {
                                                                echo "<h5><span class='badge bg-danger'>ไม่แสดง</span></h5>";
                                                            } elseif ($row["pm_show"] == 1) {
                                                                echo "<h5><span class='badge bg-success'>แสดง</span></h5>";
                                                            } else {
                                                                echo "<h5><span class='badge bg-warning'>ต้องเป็น 0 หรือ 1 เท่านั้น</span></h5>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <form method="post" action="payment_edit_form.php">
                                                                <input type="hidden" name="pm_id" value="<?php echo $row["pm_id"]; ?>">
                                                                <button type="submit" name="btn-edit" class="btn btn-warning">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                    <span>แก้ไข</span>
                                                                </button>
                                                            </form>
                                                        </td>

                                                        <td class="text-center">
                                                            <form method="post" action="payment_del_form.php">
                                                                <input type="hidden" name="pm_id" value="<?php echo $row["pm_id"]; ?>">
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
                    pm_bank: {
                        required: true,
                        minlength: 2,
                        maxlength: 50
                    },
                    pm_name: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙\s]*$/,
                        minlength: 2,
                        maxlength: 50,
                    },
                    pm_number: {
                        required: true,
                        pattern: /^[0-9\s]*$/,
                        minlength: 2,
                        maxlength: 30,
                    }
                },
                messages: {
                    pm_bank: {
                        required: "กรุณากรอก ชื่อธนาคาร ของท่าน",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    pm_name: {
                        required: "กรุณากรอก ชื่อบัญชี ของท่าน",
                        pattern: "มีได้เฉพาะ A-Z, a-z หรือ ก-ฮ เท่านั้น",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 50 ตัวอักษร"
                    },
                    pm_number: {
                        required: "กรุณากรอก เลขบัญชี ของท่าน",
                        pattern: "มีได้เฉพาะตัวเลข 0-9 เท่านั้น",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 30 ตัวอักษร"
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