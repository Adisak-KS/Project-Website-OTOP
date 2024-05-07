<?php
require_once("../db/connect.php");
$titlePage = "แสดงสินค้าเหลือน้อย";

// แสดงข้อมูล Product
try {
    $sql = "SELECT ot_product.*, ot_product_img.prd_img_name, ot_product_type.pty_name
            FROM ot_product 
            LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
            LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id
            WHERE prd_amount <= 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage();
    return false;
}


// แสดงข้อมูล Product Type
try {
    $sql = "SELECT * 
            FROM ot_product_type";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result_type = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                    <h3 class="card-title mr-1">ข้อมูลสินค้าทั้งหมด</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php if (count($result)) { ?>
                                        <table id="myTable" class="table table-bordered table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">รหัส</th>
                                                    <th class="text-center">รูปสินค้า</th>
                                                    <th class="text-center">ชื่อสินค้า</th>
                                                    <th class="text-center">ราคา</th>
                                                    <th class="text-center">จำนวน</th>
                                                    <th class="text-center">ประเภทสินค้า</th>
                                                    <th class="text-center">แสดงสินค้า</th>
                                                    <th class="text-center">แก้ไข</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $row) { ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $row["prd_id"]; ?></td>
                                                        <td class="text-center">
                                                            <img style="width: 70px; height: 70px;" src="../uploads/img_product/<?php echo $row["prd_img_name"]; ?>">
                                                        </td>
                                                        <td class="text-left"><?php echo $row["prd_name"]; ?></td>
                                                        <td class="text-left"><?php echo $row["prd_price"]; ?></td>
                                                        <td class="text-left"><?php echo $row["prd_amount"]; ?></td>
                                                        <td class="text-left"><?php echo $row["pty_name"]; ?></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($row["prd_show"] == 0) {
                                                                echo "<h5><span class='badge bg-danger'>ไม่แสดง</span></h5>";
                                                            } elseif ($row["prd_show"] == 1) {
                                                                echo "<h5><span class='badge bg-success'>แสดง</span></h5>";
                                                            } else {
                                                                echo "<h5><span class='badge bg-warning'>ต้องเป็น 0 หรือ 1 เท่านั้น</span></h5>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <form method="post" action="inventories_edit_form.php">
                                                                <input type="hidden" name="prd_id" value="<?php echo $row["prd_id"]; ?>">
                                                                <button type="submit" name="btn-edit" class="btn btn-warning">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                    <span>แก้ไข</span>
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
                    prd_name: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙0-9\s]+$/,
                        minlength: 2,
                        maxlength: 100
                    },
                    prd_price: {
                        required: true,
                        pattern: /^[1-9][0-9]*(\.\d{1,2})?$/,
                    },
                    prd_amount: {
                        required: true,
                        pattern: /^[1-9][0-9]*$/,
                    },
                    pty_id: {
                        required: true,
                    },
                },
                messages: {
                    prd_name: {
                        required: "กรุณากรอก ชื่อประเภทสินค้า",
                        minlength: "ต้องมีอย่างน้อย 2 ตัวอักษร",
                        maxlength: "ต้องไม่เกิน 100 ตัวอักษร"
                    },
                    prd_price: {
                        required: "กรุณากรอก ราคาสินค้า",
                        pattern: "ราคาไม่ถูกต้อง"
                    },
                    prd_amount: {
                        required: "กรุณากรอก จำนวนสินค้า",
                        pattern: "จำนวนสินค้าไม่ถูกต้อง"
                    },
                    pty_id: {
                        required: "กรุณากรอก ประเภทสินค้า"
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