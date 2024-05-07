<?php
require_once("db/connect.php");
$titlePage = "ตะกร้าสินค้า";

if (isset($_SESSION["mem_id"])) {
    $memId = $_SESSION["mem_id"];

    $sql = "SELECT *
            FROM ot_cart
            INNER JOIN ot_member ON ot_cart.mem_id = ot_member.mem_id
            INNER JOIN ot_product ON ot_cart.prd_id = ot_product.prd_id
            INNER JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
            WHERE ot_cart.mem_id = :mem_id";
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
        <h1 class="text-center text-white display-6">ตะกร้าสินค้า</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
            <li class="breadcrumb-item active text-white">ตะกร้าสินค้า</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->

    <div class="container-fluid py-5">
        <?php if (count($result) > 0) { ?>
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">รูปสินค้า</th>
                                <th scope="col" class="w-25">ชื่อสินค้า</th>
                                <th scope="col">ราคา/ชิ้น</th>
                                <th scope="col">จำนวน</th>
                                <th scope="col">ราคารวม</th>
                                <th scope="col">จัดการสินค้า</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <form action="product_detail.php" method="post">
                                                <button type="submit" name="btn-detail" class="btn btn-link p-0 bg-blue" style="width: 80px; height: 80px;">
                                                    <input type="hidden" name="prd_id" value="<?php echo $row["prd_id"] ?>" readonly>
                                                    <img src="uploads/img_product/<?php echo $row["prd_img_name"] ?>" class="img-fluid me-5 rounded-circle" style="width: 100%; height: 100%;" alt="">
                                                </button>
                                            </form>
                                        </div>
                                    </th>
                                    <td>
                                        <form action="product_detail.php" method="post">
                                            <button type="submit" name="btn-detail" class="text-start bg-white border-0 text-muted">
                                                <input type="hidden" name="prd_id" value="<?php echo $row["prd_id"] ?>" readonly>
                                                <p class="mb-0 mt-4"><?php echo $row["prd_name"] ?></p>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">฿<?php echo number_format($row["prd_price"], 2) ?></p>
                                    </td>
                                    <td>
                                        <input type="hidden" class="prd_amount" name="prd_amount" value="<?php echo $row["prd_amount"]; ?>" readonly>

                                        <form action="cart_update.php" method="POST">
                                            <input type="hidden" name="mem_id" value="<?php echo $row["mem_id"]; ?>">
                                            <input type="hidden" name="prd_id" value="<?php echo $row["prd_id"]; ?>">
                                            <div class="input-group mt-4" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button type="submit" name="btn-minus" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>

                                                <input type="text" name="prd_add_amount" class="form-control form-control-sm text-center border-0 bg-white prd_add_amount" value="<?php echo $row["cart_quantity"] ?>" readonly>

                                                <div class="input-group-btn">
                                                    <button type="submit" name="btn-plus" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </td>
                                    <td>
                                        <?php
                                        $total = ($row["prd_price"] * $row["cart_quantity"]);
                                        ?>
                                        <p class="mb-0 mt-4 total-prd">฿<?php echo number_format($total, 2) ?></p>
                                    </td>
                                    <td>
                                        <button data-mem_id="<?php echo $row["mem_id"]; ?>" data-prd_id="<?php echo $row["prd_id"]; ?>" class="btn btn-md rounded-circle bg-light border mt-4 btn-delete">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <!-- <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply Coupon</button> -->
                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h3 class="display-6 mb-4">รวมทั้งหมด</h3>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">ราคารวม :</h5>
                                    <p class="mb-0 total-cost"></p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">ค่าจัดส่ง : </h5>
                                    <div class="">
                                        <?php $shippingConst = 50; ?>
                                        <p class="mb-0 text-danger shipping-cost">฿<?php echo number_format($shippingConst, 2); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4 text-primary">ราคาสุทธิ :</h5>
                                <p class="mb-0 pe-4 text-primary net-price">฿</p>
                            </div>
                            <div class="py-4 mb-4 d-flex justify-content-around">
                                <form action="checkout_show.php" method="post">
                                    <?php $_SESSION["mem_id"]; ?>
                                    <button type="submit" name="btn-confirm" class="btn border-secondary px-4 py-3 text-primary text-uppercase w-100">ยีนยันรายการสั่งซื้อสินค้า</button>
                                </form>
                                <!-- <a href="checkout_show.php" class="btn border-secondary px-4 py-3 text-primary text-uppercase mx-5 w-100">ยีนยันรายการสินค้า</a> -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php } else { ?>
            <!-- หากไม่มี Product จาก Database ให้แสดงข้อมูลตัวอย่าง -->
            <div class="alert alert-warning text-center" role="alert">
                <h4 class="alert-heading">ไม่มีสินค้าอยู่ในตะกร้า</h4>
                <i class="fa-regular fa-face-frown fa-6x my-3"></i>
                <p>ถึงเค้าจะไม่ว่าง แต่เราว่างอยู่นะ!</p>
                <hr>
                <a href="index.php" class="mt-0 me-5">กลับหน้าหลัก</a>
                <a href="products_show.php" class="mt-0">ดูสินค้าอื่น ๆ</a>
            </div>
        <?php } ?>
    </div>

    <!-- Cart Page End -->


    <!-- Footer Start -->
    <?php require_once("includes/footer.php") ?>
    <?php require_once("includes/vendor.php") ?>


    <!-- ตรวจสอบจำนวนสินค้าก่อน เพิ่มลง cart  -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let btnMinusList = document.querySelectorAll('.btn-minus');
            let btnPlusList = document.querySelectorAll('.btn-plus');
            let amountList = document.querySelectorAll('.prd_add_amount');
            let maxAmountList = document.querySelectorAll('.prd_amount'); // เลือกค่าสูงสุดของจำนวนสินค้าทั้งหมด

            // วนลูปปุ่มลบ
            btnMinusList.forEach((btnMinus, index) => {
                let amount = amountList[index];
                let maxAmount = parseInt(maxAmountList[index].value);

                // ตรวจสอบและปิดปุ่มเพิ่มถ้าจำนวนเกินหรือเท่ากับจำนวนสูงสุด
                if (parseInt(amount.value) >= maxAmount) {
                    btnPlusList[index].disabled = true;
                }
                if (parseInt(amount.value) === 1) {
                    btnMinusList[index].disabled = true;
                    btnPlusList[index].disabled = false;
                }

                // เมื่อกดปุ่ม Plus
                btnPlusList[index].addEventListener('click', function() {
                    if (parseInt(amount.value) >= maxAmount) {
                        btnPlusList[index].disabled = true;
                    }
                    amount.value = parseInt(amount.value);
                    btnMinusList[index].disabled = false;
                });

                // เมื่อกดปุ่ม Minus
                btnMinusList[index].addEventListener('click', function() {
                    if (parseInt(amount.value) - 1 < maxAmount) {
                        btnPlusList[index].disabled = false;
                    }
                    if (parseInt(amount.value) > 1) {
                        amount.value = parseInt(amount.value);
                    }
                    if (parseInt(amount.value) === 1) {
                        btnMinusList[index].disabled = true;
                    }
                });

                // ตรวจสอบค่าใน input
                amount.addEventListener('input', function() {
                    // ตรวจสอบว่าค่าที่กรอกเข้ามาเป็นตัวเลขหรือไม่
                    if (isNaN(amount.value) || parseInt(amount.value) <= 0 || amount.value.trim() === '') {
                        amount.value = 1; // เปลี่ยนเป็น 1 ถ้าไม่ใช่ตัวเลขหรือเริ่มต้นด้วย 0
                        btnMinusList[index].disabled = true;
                        btnPlusList[index].disabled = false;
                    }

                    if (parseInt(amount.value) > 1 && parseInt(amount.value) < maxAmount) {
                        btnMinusList[index].disabled = false;
                        btnPlusList[index].disabled = false;
                    }

                    if (parseInt(amount.value) >= maxAmount) {
                        amount.value = maxAmount; // เปลี่ยนเป็น maxAmount ถ้าเกิน maxAmount
                        btnMinusList[index].disabled = false;
                        btnPlusList[index].disabled = true;
                    }
                    if (parseInt(amount.value) === 1) {
                        btnMinusList[index].disabled = true;
                        btnPlusList[index].disabled = false;
                    }
                });
            });
        });
    </script>

    <!-- ราคารวม -->
    <script>
        // ฟังก์ชันสำหรับคำนวณราคารวมและแสดงผล
        function calculateTotalCost() {
            // เลือกทุก elements ที่มีคลาส 'total-prd' เพื่อนับจำนวนสินค้า
            const totalPrdElements = document.querySelectorAll('.total-prd');

            let totalCost = 0; // เริ่มต้นราคารวมเป็น 0

            // วน loop ผ่านทุก total-prd element
            totalPrdElements.forEach(function(totalPrdElement) {
                // รับข้อความราคาทั้งหมดของสินค้า
                const totalPrdText = totalPrdElement.textContent;

                // แปลงข้อความราคาเป็นตัวเลขทศนิยม
                const totalPrd = parseFloat(totalPrdText.replace(/[^\d.]/g, '')); // ลบอักขระที่ไม่ใช่ตัวเลขหรือจุดทศนิยมก่อนที่จะแปลง

                // ตรวจสอบว่าราคาสินค้าเป็นตัวเลขที่ถูกต้องหรือไม่
                if (!isNaN(totalPrd)) {
                    // เพิ่มราคาสินค้าใหม่เข้าไปในราคารวมทั้งหมด
                    totalCost += totalPrd;
                }
            });

            // แสดงราคารวมทั้งหมด
            document.querySelector('.total-cost').textContent = '฿' + totalCost.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // ค่าจัดส่ง
            const shippingConst = <?php echo $shippingConst; ?>;

            // รวมราคาสุทธิโดยเพิ่มค่าจัดส่ง
            const netPrice = totalCost + shippingConst;

            // แสดงราคาสุทธิ
            document.querySelector('.net-price').textContent = '฿' + netPrice.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // เรียกใช้ฟังก์ชัน calculateTotalCost เมื่อหน้าเว็บถูกโหลด
        window.onload = calculateTotalCost;
    </script>


    <!-- ลบข้อมูล  -->
    <script>
        $(".btn-delete").click(function(e) {
            e.preventDefault();
            let memId = $(this).data('mem_id');
            let prdId = $(this).data('prd_id');

            deleteConfirm(memId, prdId);
        });

        function deleteConfirm(memId, prdId) {
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
                                url: 'cart_del.php',
                                type: 'POST',
                                data: {
                                    mem_id: memId,
                                    prd_id: prdId,
                                },
                            })
                            .done(function() {
                                // แสดง SweetAlert2 เมื่อลบสำเร็จ
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ลบสำเร็จ',
                                    text: 'สินค้าถูกลบออกจากตะกร้าแล้ว',
                                    showConfirmButton: false, // ไม่แสดงปุ่ม OK
                                    timer: 1000
                                }).then(function() {
                                    // การลบสำเร็จ ทำการ redirect ไปยังหน้า cart_show.php
                                    document.location.href = 'cart_show.php';
                                });
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