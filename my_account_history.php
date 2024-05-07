<?php
$titlePage = "ประวัติการสั่งซื้อ";

require_once("db/connect.php");

if (isset($_SESSION["mem_id"])) {
    $memId = $_SESSION["mem_id"];

    $sql = "SELECT ot_order.ord_id, ot_order.time, ot_order.cart_net_price,ot_order.ord_status, ot_order.ord_prd_number, ot_order.mem_id
    FROM ot_order
    INNER JOIN ot_product ON ot_order.prd_id = ot_product.prd_id
    WHERE ot_order.mem_id = :mem_id
    GROUP BY ot_order.ord_id
    ORDER BY ot_order.ord_id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":mem_id", $memId);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $_SESSION["error"] = "กรุณาเข้าสู่ระบบก่อนใช้งาน";
    header("Location: login_form.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("includes/head.php") ?>
</head>

<body>

    <?php require_once("includes/navbar.php") ?>

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">

        <h1 class="text-center text-white display-6">ประวัติการสั่งซื้อ</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
            <li class="breadcrumb-item"><a href="my_account_setting.php">จัดการข้อมูลส่วนตัวทั้งหมด</a></li>
            <li class="breadcrumb-item active text-white">ประวัติการสั่งซื้อ</li>
        </ol>


    </div>

    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <?php if ($result) { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">รหัสรายการ</th>
                                <th scope="col">วัน เวลา</th>
                                <th scope="col">ราคาสุทธิ</th>
                                <th scope="col">สถานะรายการ</th>
                                <th scope="col">เลขพัสดุ</th>
                                <th scope="col">จัดการ</th>
                                <th scope="col">รายการที่ยกเลิกได้</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td>
                                        <p class="mb-0 mt-4"><?php echo $row["ord_id"]; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4"><?php echo $row["time"]; ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">฿<?php echo number_format($row["cart_net_price"], 2) ?></p>
                                    </td>

                                    <td>
                                        <?php if ($row["ord_status"] == "จัดส่งแล้ว") { ?>
                                            <p class="mb-0 mt-4 text-success"><?php echo $row["ord_status"]; ?></p>
                                        <?php } elseif ($row["ord_status"] == "ยกเลิกรายการ") { ?>
                                            <p class="mb-0 mt-4 text-danger"><?php echo $row["ord_status"]; ?></p>
                                        <?php } else { ?>
                                            <p class="mb-0 mt-4 text-warning"><?php echo $row["ord_status"]; ?></p>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if (!$row["ord_prd_number"]) { ?>
                                            <p class="mb-0 mt-4 text-danger">ไม่มีหมายเลขพัสดุ</p>
                                        <?php } else { ?>
                                            <a href="https://maayoung.com/" target="_blank">
                                                <p class="mb-0 mt-4 text-success"><?php echo $row["ord_prd_number"]; ?></p>
                                            </a>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if ($row["ord_status"] == "รอชำระเงิน") { ?>
                                            <form action="checkout_show.php" method="post">
                                                <input type="hidden" name="mem_id" value="<?php echo $row["mem_id"]; ?>">
                                                <input type="hidden" name="ord_id" value="<?php echo $row["ord_id"] ?>">
                                                <button type="submit" name="btn-add-slip" class="btn btn-warning">ชำระเงิน</button>
                                            </form>
                                        <?php } else { ?>
                                            <form action="my_account_history_order.php" method="post">
                                                <input type="hidden" name="mem_id" value="<?php echo $row["mem_id"]; ?>">
                                                <input type="hidden" name="ord_id" value="<?php echo $row["ord_id"] ?>">
                                                <button type="submit" name="btn-detail" class="btn btn-primary text-white">รายละเอียด</button>
                                            </form>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if ($row["ord_status"] == "รอชำระเงิน") { ?>
                                            <button type="submit" class="btn btn-danger text-white btn-cancel-order" data-mem_id="<?php echo $row["mem_id"]; ?>" data-ord_id="<?php echo $row["ord_id"] ?>">
                                                ยกเลิก
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <!-- หากไม่มี Product จาก Database ให้แสดงข้อมูลตัวอย่าง -->
                    <div class="alert alert-warning text-center" role="alert">
                        <h4 class="alert-heading">ไม่มีประวัติการสั่งซื้อ</h4>
                        <i class="fa-regular fa-face-frown fa-6x my-3"></i>
                        <p>ถึงเค้าจะไม่ว่าง แต่เราว่างอยู่นะ!</p>
                        <hr>
                        <a href="index.php" class="mt-0 me-5">กลับหน้าหลัก</a>
                        <a href="products_show.php" class="mt-0">ดูสินค้าอื่น ๆ</a>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
    <!-- Contact End -->


    <!-- Footer Start -->
    <?php require_once("includes/footer.php") ?>
    <?php require_once("includes/vendor.php") ?>


    <!-- ให้ Confirm ก่อนยกเลิกรายการ -->
    <script>
        $(".btn-cancel-order").click(function(e) {
            e.preventDefault();
            let memId = $(this).data('mem_id');
            let ordId = $(this).data('ord_id');

            deleteConfirm(memId, ordId);
        });


        function deleteConfirm(memId, ordId) {
            Swal.fire({
                icon: "warning",
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการยกเลิกรายการนี้ใช่ไหม!",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ใช่, ยกเลิกเลย!',
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'order_cancel.php',
                                type: 'POST',
                                data: {
                                    mem_id: memId,
                                    ord_id: ordId,
                                },
                            })
                            .done(function() {
                                // การลบสำเร็จ ทำการ redirect ไปยังหน้า my_account_history.php
                                document.location.href = 'my_account_history.php';
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
<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php"); ?>