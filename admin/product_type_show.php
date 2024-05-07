<?php
require_once("../db/connect.php");

$titlePage = "แสดงประเภทสินค้า";

// แสดงข้อมูล Product Type
try {
    $sql = "SELECT * 
            FROM ot_product_type";
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
                                    <h3 class="card-title mr-1">ข้อมูลประเภทสินค้าทั้งหมด</h3>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <i class="fa-regular fa-square-plus"></i>
                                        <span>เพิ่มประเภทสินค้า</span>
                                    </button>
                                    <!-- Modal -->
                                    <form id="form" action="product_type_add.php" method="post">
                                        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">เพิ่มประเภทสินค้าใหม่</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="pty_name">ชื่อประเภทสินค้า : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="pty_name" placeholder="กรุณากรอก ชื่อประเภทสินค้า">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="pty_detail">รายละเอียด : </label><span class="text-danger">*</span>
                                                            <textarea class="form-control" name="pty_detail" rows="4" placeholder="กรุณากรอก รายละเอียดสั้น ๆ เกี่ยวกับประเภทสินค้า"></textarea>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="customRadio1">การแสดงประเภทสินค้า : </label>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input custom-control-input-success" type="radio" id="customRadio1" name="customRadio" disabled>
                                                                <label for="customRadio1" class="custom-control-label">แสดงประเภทสินค้า</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input custom-control-input-danger" type="radio" id="customRadio2" name="customRadio" checked>
                                                                <label for="customRadio2" class="custom-control-label">ไม่แสดงประเภทสินค้า</label>
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
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php if (count($result) > 0) { ?>
                                        <table id="myTable" class="table table-bordered table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">รหัส</th>
                                                    <th class="text-center">รูปประเภทสินค้า</th>
                                                    <th class="text-center">ชื่อประเภทสินค้า</th>
                                                    <th class="text-center">รายละเอียด</th>
                                                    <th class="text-center">แสดงสินค้า</th>
                                                    <th class="text-center">แก้ไข</th>
                                                    <th class="text-center">ลบ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $row) { ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $row["pty_id"] ?></td>
                                                        <td class="text-center">
                                                            <img style="width: 70px; height: 70px;" src="../uploads/img_product_type/<?php echo $row["pty_img"]; ?>">
                                                        </td>
                                                        <td class="text-left"><?php echo $row["pty_name"] ?></td>
                                                        <td class="text-left"><?php echo $row["pty_detail"] ?></td>
                                                        <td class="text-center"><?php
                                                                                if ($row["pty_show"] == 0) {
                                                                                    echo "<h5><span class='badge bg-danger'>ไม่แสดง</span></h5>";
                                                                                } elseif ($row["pty_show"] == 1) {
                                                                                    echo "<h5><span class='badge bg-success'>แสดง</span></h5>";
                                                                                } else {
                                                                                    echo "<h5><span class='badge bg-warning'>ต้องเป็น 0 หรือ 1 เท่านั้น</span></h5>";
                                                                                }
                                                                                ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <form method="post" action="product_type_edit_form.php">
                                                                <input type="hidden" name="pty_id" value="<?php echo $row["pty_id"]; ?>">
                                                                <button type="submit" name="btn-edit" class="btn btn-warning">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                    <span>แก้ไข</span>
                                                                </button>
                                                            </form>
                                                        </td>

                                                        <td class="text-center">
                                                            <form method="post" action="product_type_del_form.php">
                                                                <input type="hidden" name="pty_id" value="<?php echo $row["pty_id"]; ?>">
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
            $('#form').validate({
                rules: {
                    pty_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    pty_detail: {
                        required: true,
                        minlength: 2,
                        maxlength: 100
                    },
                },
                messages: {
                    pty_name: {
                        required: "กรุณากรอก ชื่อประเภทสินค้า",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 30 ตัวอักษร"
                    },
                    pty_detail: {
                        required: "กรุณากรอก รายละเอียดประเภทสินค้า",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 100 ตัวอักษร"
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
<?php require_once("includes/sweetalert2.php");?>