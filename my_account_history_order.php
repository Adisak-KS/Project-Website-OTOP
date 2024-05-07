<?php
$titlePage = "รายละเอียดรายการสั่งซื้อ";
require_once("db/connect.php");


if (isset($_POST["btn-detail"])) {
    $memId = $_POST["mem_id"];
    $ordId = $_POST["ord_id"];

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

    if (!$result) {
        header("Location: index.php");
        exit();
    }


    $sql = "SELECT *
            FROM ot_order_slip
            WHERE ord_id = :ord_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":ord_id", $ordId);
    $stmt->execute();
    $slip  = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1 class="text-center text-white display-6">รายละเอียดรายการสั่งซื้อ</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="my_account_history.php">ประวัติรายการสั่งซื้อ</a></li>
            <li class="breadcrumb-item active text-white">รายละเอียดรายการสั่งซื้อ</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">รายละเอียด</h1>
            <?php if ($result[0]["ord_status"] == "ยกเลิกรายการ") { ?>
                <p class="text-danger"><strong class="text-dark">สถานะรายการ : </strong><?php echo $result[0]["ord_status"]; ?></p>

            <?php } elseif ($result[0]["ord_status"] == "จัดส่งแล้ว") { ?>
                <p class="text-success"><strong class="text-dark">สถานะรายการ : </strong><?php echo $result[0]["ord_status"]; ?></p>
            <?php } else { ?>
                <p class="text-warning"><strong class="text-dark">สถานะรายการ : </strong><?php echo $result[0]["ord_status"]; ?></p>
            <?php } ?>


            <form id="form" action="checkout_add.php" method="POST">
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <input type="hidden" class="form-control" name="mem_id" value="<?php echo $result[0]["mem_id"]; ?>" readonly>
                                    <label class="form-label my-3">ชื่อ<sup>*</sup></label>
                                    <input type="text" class="form-control" name="mem_fname" value="<?php echo $result[0]["mem_fname"]; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">นามสกุล<sup>*</sup></label>
                                    <input type="text" class="form-control" name="mem_lname" value="<?php echo $result[0]["mem_lname"]; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">ที่อยู๋ <sup>*</sup></label>
                            <input type="text" class="form-control" name="mem_house_number" value="<?php echo $result[0]["mem_house_number"]; ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">อำเภอ<sup>*</sup></label>
                            <input type="text" class="form-control" name="mem_district" value="<?php echo $result[0]["mem_district"]; ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">จังหวัด<sup>*</sup></label>
                            <input type="text" class="form-control" name="mem_province" value="<?php echo $result[0]["mem_province"]; ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">รหัสไปรษณีย์<sup>*</sup></label>
                            <input type="text" class="form-control" name="mem_zip_code" value="<?php echo $result[0]["mem_zip_code"]; ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">เบอร์โทรศัพท์<sup>*</sup></label>
                            <input type="tel" class="form-control" name="mem_tel" value="<?php echo $result[0]["mem_tel"]; ?>" disabled>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">อีเมล<sup>*</sup></label>
                            <input type="email" class="form-control" name="mem_email" value="<?php echo $result[0]["mem_email"]; ?>" readonly>
                        </div>

                        <?php if (!empty($result[0]["mem_detail"])) { ?>
                            <div class="form-item mt-2">
                                <label class="form-label my-3">เพิ่มเติม<sup>*</sup></label>
                                <textarea class="form-control" name="mem_detail" spellcheck="false" cols="30" rows="5" placeholder="บอกรายละเอียดที่อยู่เพิ่มเติมให้กับพนักงานจัดส่งได้ทราบ (ไม่ระบุก็ได้)" disabled><?php echo $result[0]["mem_detail"] ?></textarea>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-5">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">รูป</th>
                                        <th scope="col">ชื่อสินค้า</th>
                                        <th scope="col">ราคา</th>
                                        <th scope="col">จำนวน</th>
                                        <th scope="col">ราคารวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row) { ?>
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="uploads/img_product/<?php echo $row["prd_img_name"] ?>" class="img-fluid rounded-circle mt-0" style="width: 80px; height: 80px;" alt="">
                                                </div>
                                            </th>
                                            <td class="py-5"><?php echo mb_strlen($row["prd_name"], 'UTF-8') > 10 ? mb_substr($row["prd_name"], 0, 10, 'UTF-8') . "..." : $row["prd_name"]; ?></td>

                                            <td class="py-5"><?php echo number_format($row["prd_price"], 2) ?></td>
                                            <td class="py-5"><?php echo $row["cart_quantity"] ?></td>
                                            <?php
                                            $totalPrdPrice = ($row["prd_price"] * $row["cart_quantity"]);
                                            ?>

                                            <td class="py-5">฿<?php echo number_format($totalPrdPrice, 2); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-5"></td>
                                        <td class="py-5"></td>
                                        <td class="py-5">
                                            <p class="mb-0 text-dark py-3">ทั้งหมด</p>
                                        </td>
                                        <td class="py-5">
                                            <div class="py-3 border-bottom border-top">
                                                <?php
                                                $totalPrice = 0; // สร้างตัวแปรเพื่อเก็บราคารวมทั้งหมด

                                                foreach ($result as $row) {
                                                    $totalPrice += ($row["prd_price"] * $row["cart_quantity"]); // เพิ่มราคารวมของแต่ละสินค้าลงในตัวแปร $totalPrice
                                                }
                                                ?>
                                                <p class="mb-0 text-dark">฿<?php echo number_format($totalPrice, 2) ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-5">
                                            <p class="mb-0 text-dark py-4">ค่าจัดส่ง</p>
                                        </td>
                                        <td colspan="3" class="py-5">
                                            <div class="text-start">
                                                <?php $_SESSION["shippingConst"] = 50; ?>
                                                <input type="text" class="text-end mt-4 mx-5 text-danger border-0 bg-white" value="<?php echo "฿" . number_format(50, 2) ?>" disabled>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-5">
                                            <p class="mb-0 text-primary text-uppercase py-3">ราคาสุทธิ</p>
                                        </td>
                                        <td class="py-5"></td>
                                        <td class="py-5"></td>
                                        <td class="py-5">
                                            <div class="py-3 border-bottom border-top">
                                                <?php
                                                $netPrice = $totalPrice  + 50;
                                                $_SESSION["netPrice"] = $netPrice;
                                                ?>
                                                <p class="mb-0 text-primary">฿<?php echo number_format($netPrice, 2) ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12 form-item text-start">
                                <div class="form-check text-start my-3">
                                    <input type="checkbox" class="form-check-input bg-primary border-0" checked disabled>
                                    <label class="form-check-label" for="Paypal-1">โอนเงินพร้อมแนบหลักฐานการชำระเงิน</label>
                                    <div class="card-body d-flex justify-content-center">
                                        <?php if ($slip) { ?>
                                            <div id="slipCarousel" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <?php foreach ($slip as $index => $row) { ?>
                                                        <button type="button" data-bs-target="#slipCarousel" data-bs-slide-to="<?php echo $index; ?>" <?php echo $index === 0 ? 'class="active"' : ''; ?> aria-label="Slide <?php echo $index + 1; ?>"></button>
                                                    <?php } ?>
                                                </div>
                                                <div class="carousel-inner">
                                                    <?php foreach ($slip as $index => $row) { ?>
                                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                            <img src="uploads/img_slip/<?php echo $row["ord_slip_img"]; ?>" class="d-block mx-auto" width="300" height="600" alt="Slide <?php echo $index + 1; ?>">
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
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <a href="my_account_setting.php" type="button" class="btn form-control py-3 ms-5 bg-gray text-secondary me-5">กลับหน้าประวัติรายการสั่งซื้อ</a>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
        </div>
    </div>
    <!-- Checkout Page End -->


    <!-- Footer Start -->
    <?php require_once("includes/footer.php"); ?>
    <?php require_once("includes/vendor.php"); ?>

    <script>
        $(function() {
            $('#form').validate({
                rules: {
                    mem_fname: {
                        required: true,
                    },
                    mem_lname: {
                        required: true,
                    },
                    mem_house_number: {
                        required: true,
                    },
                    mem_district: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙\s]+$/,
                    },
                    mem_province: {
                        required: true,
                        pattern: /^[a-zA-Zก-๙\s]+$/,
                    },
                    mem_zip_code: {
                        required: true,
                        pattern: /^\d{5}$/, // ระบุให้รับเฉพาะตัวเลขและจำนวน 5 ตัว
                    },
                    mem_tel: {
                        required: true,
                        pattern: /^\d{10}$/, // ระบุให้รับเฉพาะตัวเลขและจำนวน 10 ตัว
                    },
                    mem_email: {
                        required: true,
                    },
                    transfer: {
                        required: true,
                    },
                },
                messages: {
                    mem_fname: {
                        required: "กรุณากรอก ชื่อ ของท่าน",
                    },
                    mem_lname: {
                        required: "กรุณากรอก นามสกุล ของท่าน",
                    },
                    mem_house_number: {
                        required: "กรุณากรอก บ้านเลขที่ ของท่าน",
                    },
                    mem_district: {
                        required: "กรุณากรอก อำเภอ ของท่าน",
                        pattern: "มีได้เฉพาะ ก-ฮ, a-z เท่านั้น",
                    },
                    mem_province: {
                        required: "กรุณากรอก จังหวัด ของท่าน",
                        pattern: "มีได้เฉพาะ ก-ฮ, a-z เท่านั้น",
                    },
                    mem_zip_code: {
                        required: "กรุณากรอก รหัสไปรษณีย์ ของท่าน",
                        pattern: "ต้องเป็นตัวเลข จำนวน 5 ตัว"
                    },
                    mem_tel: {
                        required: "กรุณากรอก เบอร์โทร ของท่าน",
                        pattern: "ต้องเป็นตัวเลข จำนวน 10 ตัว"
                    },
                    transfer: {
                        required: "กรุณาเลือกช่องทางชำระเงิน",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-item').append(error);
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