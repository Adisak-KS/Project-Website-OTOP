<?php
$titlePage = "หลักฐานการชำระเงิน";
require_once("db/connect.php");

if (isset($_POST["btn-add-slip"])) {
    $_SESSION["ord_id"] = $_POST["ord_id"];
}


try {
    $sql = "SELECT *
            FROM ot_payment
            WHERE pm_show = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
    return false;
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
        <h1 class="text-center text-white display-6">หลักฐานการชำระเงิน</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="cart_show.php">ตะกร้าสินค้า</a></li>
            <li class="breadcrumb-item active text-white">หลักฐานการชำระเงิน</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-1">
        <form id="form" action="slip_add.php" method="post" enctype="multipart/form-data">
            <?php $_SESSION["ord_id"] ?>
            <!-- ส่ง $_SESSION["ord_id"]; ไปด้วย เพื่อระบุว่าเป็นของรายการใด  -->
            <!-- $_SESSION["ord_id"]; -->

            <?php if ($result) { ?>
                <div class="container py-4 text-center">
                    <img src="uploads/img_payment/<?php echo $result["pm_qrcode"];?>" style="width: 350px; height:300px">
                </div>
                <div class="text-center">
                    <p><strong>บัญชีธนาคาร :</strong> <?php echo $result["pm_bank"] ?></p>
                    <p><strong>ชื่อบัญชี :</strong><?php echo $result["pm_name"] ?></p>
                    <p><strong>เลขบัญชี :</strong><?php echo $result["pm_number"] ?></p>
                    <?php $netPrice = $_SESSION["netPrice"]; ?>
                    <p><strong>จำนวนเงิน :</strong> ฿<?php echo number_format($netPrice, 2) ?> บาท</p>
                <?php }else{ ?>
                    <div class="container py-4 text-center">
                <img src="uploads/img_payment/default.png" style="width: 200px; height:300px">
            </div>
            <div class="text-center">
                <p><strong>บัญชีธนาคาร :</strong> ออมสิน</p>
                <p><strong>ชื่อบัญชี :</strong> นายอดิศักดิ์ คงสุข</p>
                <p><strong>เลขบัญชี :</strong> 15876358785444</p>
                <?php $netPrice = $_SESSION["netPrice"]; ?>
                <p><strong>จำนวนเงิน :</strong> ฿<?php echo number_format($netPrice, 2) ?> บาท</p>
                <?php } ?>

                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="form-item col-md-3 col-lg-3 text-center">

                        <label for="formFile" class="form-label text-start"><strong>หลักฐานการชำระเงิน :</strong></label>
                        <input class="form-control bg-white" type="file" name="ord_slip_img">
                    </div>
                </div>
                <hr>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="col-md-3 col-lg-3 text-center">
                        <button type="submit" name="btn-add-slip" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">อัปโหลดหลักฐานการชำระเงิน</button>
                    </div>
                </div>
        </form>
    </div>
    <!-- Checkout Page End -->


    <!-- Footer Start -->
    <?php require_once("includes/footer.php"); ?>
    <?php require_once("includes/vendor.php"); ?>

    <script>
        $(function() {
            $('#form').validate({
                rules: {
                    ord_slip_img: {
                        required: true,
                        accept: "image/png, image/jpeg, image/jpg"
                    },
                },
                messages: {
                    ord_slip_img: {
                        required: "กรุณา เลือกไฟล์สลิปโอนเงิน ของท่าน",
                        accept: "ต้องเป็น PNG, JPEG, หรือ JPG เท่านั้น"
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
<?php require_once("includes/sweetalert2.php"); ?>