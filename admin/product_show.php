<?php
require_once("../db/connect.php");
$titlePage = "แสดงสินค้า";


// ตรวจสอบว่ามี Product Type หรือไม่ (เกี่ยวกับปุ่ม เพิ่ม Product)
try {
    $sql = "SELECT COUNT(*) 
            AS pty_count 
            FROM ot_product_type";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $productTypeCount = $stmt->fetch();
    $ptyCount = $productTypeCount['pty_count'];
} catch (Exception $e) {
    echo $e->getMessage();
    return false;
}


// แสดงข้อมูล Product
try {
    $sql = "SELECT ot_product.*, ot_product_img.prd_img_name, ot_product_type.pty_name
            FROM ot_product 
            LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
            LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result_prd = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                    <style>
                                        button.disabled {
                                            pointer-events: none;
                                            color: #ccc;
                                        }
                                    </style>

                                    <?php if ($ptyCount > 0) {
                                        // มีข้อมูล Product Type
                                        echo '
                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="fa-regular fa-square-plus"></i>
                                                <span>เพิ่มสินค้า</span>
                                            </button>
                                            ';
                                    } else {
                                        // ไม่มีข้อมูล Product Type
                                        echo '
                                            <button class="btn btn-success disabled" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="fa-regular fa-square-plus"></i>
                                                <span>เพิ่มสินค้า</span>
                                            </button> <p></p>
                                            ';
                                        echo '
                                            <div class="alert alert-warning text-black" role="alert">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                                ต้องมีประเภทสินค้าอย่างน้อย 1 ประเภท จึงจะสามารถเพิ่มสินค้าได้ 
                                                <a class="text-white" href="product_type_show.php">เพิ่มประเภทสินค้าที่นี่</a>
                                            </div>
                                            ';
                                    }
                                    ?>

                                    <!-- Modal -->
                                    <form id="form" action="product_add.php" method="post">
                                        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">เพิ่มสินค้าใหม่</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="prd_name">ชื่อสินค้า : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="prd_name" placeholder="กรุณากรอก ชื่อสินค้า">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="prd_price">ราคา : </label><span class="text-danger">*</span>
                                                            <div class="input-group">
                                                                <input class="form-control" type="text" name="prd_price" placeholder="กรุณากรอก ราคาสินค้า เช่น 190, 145.55">
                                                                <span class="input-group-text">บาท</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="prd_amount">จำนวนสินค้า : </label><span class="text-danger">*</span>
                                                            <input class="form-control" type="text" name="prd_amount" placeholder="กรุณากรอก จำนวนสินค้า">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label" for="pty_id">ประเภทสินค้า :</label><span class="text-danger">*</span>
                                                            <select class="form-select" name="pty_id">
                                                                <option value="">โปรดเลือกประเภทสินค้า</option>
                                                                <?php foreach ($result_type as $row) { ?>
                                                                    <option value="<?php echo $row["pty_id"]; ?>"><?php echo $row["pty_name"]; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="customRadio1">การแสดงสินค้า : </label>
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

                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php if (count($result_prd) > 0) { ?>
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
                                                    <th class="text-center">ลบ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result_prd as $row) { ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $row["prd_id"]; ?></td>
                                                        <td class="text-center">
                                                            <img style="width: 70px; height: 70px;" src="../uploads/img_product/<?php echo $row["prd_img_name"]; ?>">
                                                        </td>
                                                        <td class="text-left"><?php echo $row["prd_name"]; ?></td>
                                                        <td class="text-left">฿<?php echo number_format($row["prd_price"],2) ?></td>
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
                                                            <form method="post" action="product_edit_form.php">
                                                                <input type="hidden" name="prd_id" value="<?php echo $row["prd_id"]; ?>">
                                                                <button type="submit" name="btn-edit" class="btn btn-warning">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                    <span>แก้ไข</span>
                                                                </button>
                                                            </form>
                                                        </td>

                                                        <td class="text-center">
                                                            <form method="post" action="product_del_form.php">
                                                                <input type="hidden" name="prd_id" value="<?php echo $row["prd_id"]; ?>">
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
                    prd_name: {
                        required: true,
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