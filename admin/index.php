<?php
require_once("../db/connect.php");

$titlePage = "หน้าแรก";


// แสดงรายการสัง่ซื้อที่มี ord_status = 'รอตรวจสอบ'
try {
    $sql = "SELECT ord_id
            FROM ot_order
            WHERE ord_status = 'รอตรวจสอบ'
            GROUP BY ord_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $countOrder = count($result);
} catch (Exception $e) {
    echo $e->getMessage();
    return false;
}


// แสดงรายการสัง่ซื้อที่มี ord_status = 'รอจัดส่ง'
try {
    $sql = "SELECT *
            FROM ot_order
            WHERE ord_status = 'รอจัดส่ง'
            GROUP BY ord_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $countDelivery = count($result);
} catch (Exception $e) {
    echo $e->getMessage();
    return false;
}

// แสดงรายการสัง่ซื้อที่มี ord_status = 'จัดส่งแล้ว'
try {
    $sql = "SELECT *
            FROM ot_order
            WHERE ord_status = 'จัดส่งแล้ว'
            GROUP BY ord_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $countDeliverySuccess = count($result);
} catch (Exception $e) {
    echo $e->getMessage();
    return false;
}


// แสดงสินค้าที่น้อยกว่า 5 ขิ้น
try {
    $sql = "SELECT prd_id
            FROM ot_product
            WHERE prd_amount <= 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $countPrdAmount = count($result);
} catch (Exception $e) {
    echo $e->getMessage();
    return false;
}

// แสดงข้อมูลที่มีการติดต่อเรามา
try {
    $sql = "SELECT em_id
            FROM ot_email
            WHERE em_show = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $countContact = count($result);
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
        <?php require_once("includes/preloader.php");
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
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p>คำสั่งซื้อสินค้า</p>
                                    <h3><?php echo  $countOrder; ?></h3>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </div>
                                <a href="order_show.php" class="small-box-footer">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>รอจัดส่งสินค้า</p>
                                    <h3><?php echo  $countDelivery; ?></h3>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-cart-flatbed"></i>
                                </div>
                                <a href="delivery_show.php" class="small-box-footer">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <p>สินค้าเหลือน้อยกว่า 5 ชิ้น</p>

                                    <h3><?php echo  $countPrdAmount; ?></h3>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-box-archive"></i>
                                </div>
                                <a href="inventories_show.php" class="small-box-footer">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>รายงานยอดขาย</p>

                                    <h3><?php echo   $countDeliverySuccess; ?></h3>
                                </div>
                                <div class="icon">
                                <i class="fa-solid fa-square-poll-vertical"></i>
                                </div>
                                <a href="report_show.php" class="small-box-footer">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>ติดต่อเรา</p>

                                    <h3><?php echo  $countContact; ?></h3>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <a href="email_show.php" class="small-box-footer">
                                    ดูเพิ่มเติม
                                    <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                        </section>
                        <!-- right col -->
                    </div>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
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

<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php"); ?>