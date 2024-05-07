<?php
require_once("../db/connect.php");

$titlePage = "แก้ไขข้อมูลสินค้า";

// รับ id
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-edit"])) {
    if (isset($_POST["prd_id"])) {
        $prdId = $_POST["prd_id"];
        $_SESSION["prd_id"] = $prdId; // เก็บค่า ID ใน session
    }
} else {
    header("Location: inventories_show.php");
    exit;
}

// แสดงข้อมูล Product ตาม ID
if (isset($_SESSION["prd_id"])) {
    $prdId = $_SESSION["prd_id"];
    try {
        $sql = "SELECT ot_product.*, ot_product_img.prd_img_name, ot_product_type.pty_name
                FROM ot_product 
                LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
                LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id
                WHERE ot_product.prd_id = :prd_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":prd_id", $prdId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
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
        <!-- Preloader -->
        <?php //require_once("includes/preloader.php"); 
        ?>
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
                <form id="form" action="inventories_edit.php" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            ข้อมูลทั่วไป
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="prd_id">รหัสสินค้า : </label>
                                            <input class="form-control" type="text" name="prd_id" value="<?php echo $result["prd_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="prd_name">ชื่อสินค้า : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="prd_name" placeholder="กรุณากรอก ชื่อสินค้า" value="<?php echo $result["prd_name"] ?>"disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="prd_price">ราคา : </label><span class="text-danger">*</span>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="prd_price" placeholder="กรุณากรอก ราคาสินค้า เช่น 190, 145.55" value="<?php echo $result["prd_price"] ?>"disabled>
                                                <span class="input-group-text">บาท</span>
                                            </div>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="prd_amount">จำนวน : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="prd_amount" placeholder="กรุณากรอก ชื่อสินค้า" value="<?php echo $result["prd_amount"] ?>">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="prd_detail">รายละเอียด : </label><span class="text-danger">*</span>
                                            <textarea class="form-control" name="prd_detail" rows="4" placeholder="กรุณากรอก รายบะเอียดสินค้า" disabled><?php echo $result["prd_detail"] ?></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pty_id">ประเภทสินค้า :</label><span class="text-danger">*</span>
                                            <div class="input-group">
                                                <select class="form-select" name="pty_id" disabled>
                                                    <option value="">โปรดเลือกประเภทสินค้า</option>
                                                    <!-- ตรวจสอบว่า $row["pty_id"] ตรงกับค่าใน $result["pty_id"] หากตรงกับใน Database ให้ selected เพื่อให้ option นั้นถูกเลือกเริ่มต้น -->
                                                    <?php foreach ($result_type as $row) { ?>
                                                        <option value="<?php echo $row["pty_id"]; ?>" <?php if ($row["pty_id"] == $result["pty_id"]) echo "selected"; ?>>
                                                            <?php echo $row["pty_name"]; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="prd_show">การแสดงสินค้า : </label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success" type="radio" id="show" name="prd_show" value="1" <?php if ($result["prd_show"] == "1") echo "checked"; ?> disabled>
                                                <label for="show" class="custom-control-label">แสดงสินค้า</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <!-- หากการแสดงสินค่ามีค่า = 0 หรือ มีค่าไม่ใช่เลข 1 ให้ checked  -->
                                                <input class="custom-control-input custom-control-input-danger" type="radio" id="hide" name="prd_show" value="0" <?php if ($result["prd_show"] == "0" || $result["prd_show"] != "1") echo "checked"; ?> disabled>
                                                <label for="hide" class="custom-control-label">ไม่แสดงสินค้า</label>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-6">
                                <div class="card card-warning pb-5">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            รูปภาพสินค้า
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="prd_img">รูปภาพสินค้า : </label>
                                            <br>
                                            <img class="mx-auto d-block border" style="width:300px; height:250px" id="prd_img" name="prd_img" src="../uploads/img_product/<?php echo $result["prd_img_name"]; ?>">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-12">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            จัดการข้อมูล
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <a href="inventories_show.php" class="btn btn-secondary" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                ยกเลิก
                                            </a>
                                            <button class="btn btn-warning" type="submit" name="btn-edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                บันทึกการแก้ไข
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                    prd_amount: {
                        required: true,
                        pattern: /^[1-9][0-9]*$/,
                    },
                },
                messages: {
                    prd_amount: {
                        required: "กรุณากรอก จำนวนสินค้า",
                        pattern: "จำนวนสินค้าไม่ถูกต้อง"
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
<?php require_once("includes/sweetalert2.php"); ?>