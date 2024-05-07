<?php
require_once("../db/connect.php");
$titlePage = "แสดงยอดขาย";


// แสดงรายการสินค้าที่มีสถานะ "รอตรวจสอบ" (order_status = 'รอจัดส่ง')
try {
    $sql = "SELECT *
    FROM ot_order
    INNER JOIN ot_product ON ot_order.prd_id = ot_product.prd_id
    WHERE ot_order.ord_status = 'จัดส่งแล้ว'
    GROUP BY ord_id";
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
                                    <h3 class="card-title mr-1">ข้อมูลยอดขายทั้งหมด</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php if (count($result)) { ?>
                                        <table id="myTable" class="table table-bordered table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">รหัส</th>
                                                    <th class="text-center">วัน เวลา สั่งซื้อ</th>
                                                    <th class="text-center">สถานะ</th>
                                                    <th class="text-center">ราคาสุทธิ</th>
                                                    <th class="text-center">ตรวจสอบ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $row) { ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $row["ord_id"]; ?></td>
                                                        <td class="text-left"><?php echo $row["time"]; ?></td>
                                                        <td class="text-center">
                                                            <span class="badge bg-warning text-white fs-6">
                                                                <?php echo $row["ord_status"]; ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-left">฿<?php echo number_format($row["cart_net_price"], 2) ?></td>

                                                        <td class="text-center">
                                                            <form method="post" action="report_detail_form.php">
                                                                <input type="hidden" name="mem_id" value="<?php echo $row["mem_id"]; ?>">
                                                                <input type="hidden" name="ord_id" value="<?php echo $row["ord_id"]; ?>">
                                                                <button type="submit" name="btn-edit" class="btn btn-secondary">
                                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                                    <span>รายละเอียด</span>
                                                                </button>
                                                            </form>
                                                        </td>


                                                    <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-end">ยอดรวมทั้งหมด :</th>
                                                    <?php
                                                    $totalNetPrice = 0;
                                                    foreach ($result as $row) {

                                                        // เพิ่มราคารวมของสินค้าแต่ละชิ้นเข้าไปยังราคารวมทั้งหมด
                                                        $totalNetPrice += $row["cart_net_price"];
                                                    }
                                                    ?>
                                                    <th class="text-start">฿<?php echo number_format($totalNetPrice, 2) ?></th>
                                                </tr>
                                            </tfoot>
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
</body>

</html>
<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php"); ?>