<?php
require_once("../db/connect.php");

$titlePage = "ลบข้อมูลสินค้า";

// รับ id
if (isset($_POST["btn-del"])) {
    $prdId = $_POST["prd_id"];
    $_SESSION["prd_id"] = $prdId; // เก็บค่า ID ใน session
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

        $sql = "SELECT prd_id
                FROM ot_order
                WHERE prd_id = :prd_id
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":prd_id", $prdId);
        $stmt->execute();
        $check = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} elseif (isset($_SESSION["prd_id"])) {
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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT prd_id
                FROM ot_order
                WHERE prd_id = :prd_id
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":prd_id", $prdId);
        $stmt->execute();
        $check = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location:product_show.php");
    exit;
}

// ไม่มีข้อมูลจาก Database
if (!$result) {
    header("Location:product_show.php");
    exit;
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
                <form id="form" action="product_edit.php" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            ข้อมูลทั่วไป
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="prd_id">รหัสสินค้า : </label>
                                            <input class="form-control" type="text" name="prd_id" value="<?php echo $result["prd_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="prd_name">ชื่อสินค้า : </label>
                                            <input class="form-control" type="text" name="prd_name" placeholder="กรุณากรอก ชื่อสินค้า" value="<?php echo $result["prd_name"] ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="prd_price">ราคา : </label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="prd_price" placeholder="กรุณากรอก ราคาสินค้า เช่น 190, 145.55" value="<?php echo $result["prd_price"] ?>" disabled>
                                                <span class="input-group-text">บาท</span>
                                            </div>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="prd_amount">จำนวน : </label>
                                            <input class="form-control" type="text" name="prd_amount" placeholder="กรุณากรอก ชื่อสินค้า" value="<?php echo $result["prd_amount"] ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="prd_detail">รายละเอียด : </label>
                                            <textarea class="form-control" name="prd_detail" rows="4" placeholder="กรุณากรอก รายบะเอียดสินค้า" disabled><?php echo $result["prd_detail"] ?></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pty_id">ประเภทสินค้า :</label>
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
                                <div class="card card-danger pb-5">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            รูปภาพสินค้า
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="prd_img">รูปภาพสินค้า : </label>
                                            <br>
                                            <img class="mx-auto d-block border" style="width:300px; height:250px" id="prd_img" name="prd_img" src="../uploads/img_product/<?php echo $result["prd_img_name"]; ?>">
                                            <input class="form-control" type="hidden" name="prd_img" value="<?php echo $result["prd_img_name"]; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-12">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            จัดการข้อมูล
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <?php if($check){ ?>
                                                <p class="text-danger"><strong>!! สินค้านี้มีผู้ซื้อแล้ว หากท่านลบจะส่งผลต่อประวัติการสั่งซื้อสินค้าของสมาชิกจะหายไปและ เมนูรายการสั่งซื้อจะแสดง Error !!</strong></p>
                                            <?php } ?>
                                            <a href="product_show.php" class="btn btn-secondary" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                ยกเลิก
                                            </a>
                                            <!-- ส่ง prd_id และ prd_img  -->
                                            <a data-prd_id="<?php echo $result["prd_id"]; ?>" data-prd_img_name="<?php echo $result["prd_img_name"]; ?>" class="btn btn-danger btn-delete">
                                                <i class="fa-solid fa-trash"></i>
                                                ลบข้อมูล
                                            </a>

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

    <script>
        $(".btn-delete").click(function(e) {
            e.preventDefault();
            let prdId = $(this).data('prd_id');
            let prdImgName = $(this).data('prd_img_name');

            deleteConfirm(prdId, prdImgName);
        });


        function deleteConfirm(prdId, prdImgName) {
            Swal.fire({
                icon: "warning",
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการลบข้อมูลนี้ใช่ไหม!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ใช่, ลบข้อมูลเลย!',
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'product_del.php',
                                type: 'POST',
                                data: {
                                    prd_id: prdId,
                                    prd_img_name: prdImgName
                                },
                            })
                            .done(function() {
                                // การลบสำเร็จ ทำการ redirect ไปยังหน้า product_show.php
                                document.location.href = 'product_show.php';
                            })
                            .fail(function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ไม่สำเร็จ',
                                    text: 'เกิดข้อผิดพลาดที่ ajax !',
                                });
                            });
                    });
                },
            });
        }
    </script>

</body>

</html>
<?php require_once("includes/sweetalert2.php") ?>