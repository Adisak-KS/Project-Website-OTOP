<?php
require_once("../db/connect.php");

$titlePage = "ข้อมูลรายการที่จัดส่งสำเร็จ";

if (isset($_POST["btn-edit"])) {
    $memId = $_POST["mem_id"];
    $ordId = $_POST["ord_id"];


    try {
        $sql = "SELECT *
                FROM ot_order
                INNER JOIN ot_member ON ot_order.mem_id = ot_member.mem_id
                INNER JOIN ot_product ON ot_order.prd_id = ot_product.prd_id
                INNER JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
                WHERE ot_order.mem_id = :mem_id AND ot_order.ord_id = :ord_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->bindParam(":ord_id", $ordId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT *
                FROM ot_order_slip
                WHERE ord_id = :ord_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":ord_id", $ordId);
        $stmt->execute();
        $slip  = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location: delivery_show.php");
    exit;
}

if (!$result) {
    header("Location: delivery_show.php");
    exit;
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
                <form id="form" action="delivery_edit.php" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            ข้อมูลที่อยู่
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <input class="form-control" type="hidden" name="ord_id" value="<?php echo $result[0]["ord_id"]; ?>" readonly>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_fname">ชื่อ : </label>
                                            <input class="form-control" type="text" name="mem_fname" value="<?php echo $result[0]["mem_fname"]; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_lname">นามสกุล : </label>
                                            <input class="form-control" type="text" name="mem_lname" value="<?php echo $result[0]["mem_lname"]; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_house_number">บ้านเลขที่,ตำบล : </label>
                                            <input class="form-control" type="text" name="mem_house_number" value="<?php echo $result[0]["mem_house_number"] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_district">อำเภอ : </label>
                                            <input class="form-control" type="text" name="mem_district" value="<?php echo $result[0]["mem_district"] ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_province">จังหวัด : </label>
                                            <input class="form-control" type="text" name="mem_province" value="<?php echo $result[0]["mem_province"]; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_zip_code">รหัสไปรษณีย์ : </label>
                                            <input class="form-control" type="text" name="mem_zip_code" value="<?php echo $result[0]["mem_zip_code"]; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_tel">เบอร์โทรศัพท์ : </label>
                                            <input class="form-control" type="text" name="mem_tel" value="<?php echo $result[0]["mem_tel"]; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_email">อีเมล : </label>
                                            <input class="form-control" type="text" name="mem_email" value="<?php echo $result[0]["mem_email"]; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="mem_detail">รายละเอียด : </label>
                                            <textarea class="form-control" name="mem_detail" rows="4" disabled><?php echo $result[0]["mem_detail"]; ?></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pty_id">สถานะรายการ :</label><span class="text-danger">*</span>
                                            <div class="input-group">
                                                <select class="form-select" name="ord_status">
                                                    <option value="">โปรดเลือกสถานะรายการ</option>
                                                    <option value="จัดส่งแล้ว">จัดส่งแล้ว</option>
                                                    <option value="รอชำระเงิน">ชำระเงินใหม่อีกครั้ง</option>
                                                    <option value="ยกเลิกรายการ">ยกเลิกรายการ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="ord_prd_number">เลขพัสดุ : </label>
                                            <input class="form-control" type="text" name="ord_prd_number" placeholder="กรุณากรอกเลขพัสดุ">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-6">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            รายการสินค้า
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="myTable" class="table table-bordered table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">ชื่อ</th>
                                                    <th class="text-center">ราคา</th>
                                                    <th class="text-center">จำนวน</th>
                                                    <th class="text-center">ราคารวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $row) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex justify-content-center align-items-center rounded-circle">
                                                                <img src="../uploads/img_product/<?php echo $row["prd_img_name"]; ?>" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">
                                                            </div>
                                                        </td>

                                                        <td><?php echo $row["prd_name"]; ?></td>
                                                        <td>฿<?php echo number_format($row["prd_price"], 2); ?></td>
                                                        <td><?php echo $row["cart_quantity"]; ?></td>
                                                        <?php
                                                        $totalPrdPrice = ($row["prd_price"] * $row["cart_quantity"]);
                                                        ?>
                                                        <td class="text-end"><?php echo "฿" . number_format($totalPrdPrice, 2); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end">ราคารวม : </td>
                                                    <?php
                                                    $totalPrdPriceAll = 0;
                                                    foreach ($result as $row) {
                                                        // คำนวณราคารวมของสินค้าแต่ละชิ้น
                                                        $totalPrdPrice = ($row["prd_price"] * $row["cart_quantity"]);

                                                        // เพิ่มราคารวมของสินค้าแต่ละชิ้นเข้าไปยังราคารวมทั้งหมด
                                                        $totalPrdPriceAll += $totalPrdPrice;
                                                    }
                                                    ?>
                                                    <td class="text-end"> ฿<?php echo number_format($totalPrdPriceAll, 2); ?> </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-end">ค่าจัดส่ง : </td>
                                                    <td class="text-end">฿<?php echo number_format($row["cart_shipping_const"], 2); ?></td>
                                                </tr>
                                                <tr>

                                                    <th colspan="4" class="text-end">ราคาสุทธิ : </th>
                                                    <?php $netPrice = ($totalPrdPriceAll + $row["cart_shipping_const"]); ?>
                                                    <th class="text-end">฿<?php echo number_format($netPrice, 2); ?></th>

                                                </tr>


                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            หลักฐานการชำระเงิน
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body d-flex justify-content-center">
                                            <div id="slipCarousel" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <?php foreach ($slip as $index => $row) { ?>
                                                        <button type="button" data-bs-target="#slipCarousel" data-bs-slide-to="<?php echo $index; ?>" <?php echo $index === 0 ? 'class="active"' : ''; ?> aria-label="Slide <?php echo $index + 1; ?>"></button>
                                                    <?php } ?>
                                                </div>
                                                <div class="carousel-inner">
                                                    <?php foreach ($slip as $index => $row) { ?>
                                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                            <img src="../uploads/img_slip/<?php echo $row["ord_slip_img"]; ?>" class="d-block mx-auto" width="300" height="600" alt="Slide <?php echo $index + 1; ?>">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#slipCarousel" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#slipCarousel" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            จัดการข้อมูล
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <a href="report_show.php" class="btn btn-secondary" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                                ยกเลิก
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


</body>

</html>
<?php require_once("includes/sweetalert2.php"); ?>