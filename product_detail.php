<?php
$titlePage = "รายละเอียดสินค้า";
require_once("db/connect.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-detail"])) {
    if (isset($_POST["prd_id"])) {
        $prdId = $_POST["prd_id"];
        $_SESSION["prd_id"] = $prdId; // เก็บค่า ID ใน session
    }
}

if (isset($_SESSION["prd_id"])) {
    $prdId =  $_SESSION["prd_id"];

    try {
        $sql = "SELECT * FROM ot_product 
                LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
                LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id
                WHERE ot_product.prd_id = :prd_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":prd_id", $prdId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location: index.php");
}

// แสดง Product แนะนำ แบบสุ่ม จำนวน 5 รายการ
try {
    $sql = "SELECT * FROM ot_product
            LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
            WHERE prd_show = 1 
            ORDER BY RAND() 
            LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $prd_rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
    return false;
}


// แสดง Product ใหม่ล่าสุด จำนวน 8 รายการ
try {
    $sql = "SELECT * FROM ot_product
            LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
            LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id
            WHERE prd_show = 1 
            ORDER BY ot_product.prd_id 
            DESC LIMIT 8";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $prd_new = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1 class="text-center text-white display-6">รายละเอียดสินค้า</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
            <li class="breadcrumb-item active text-white">รายละเอียดสินค้า</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="uploads/img_product/<?php echo $result["prd_img_name"] ?>" class="img-fluid rounded w-100" style="height: 550px;" alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form action="product_cart_add.php" method="post" onsubmit="return validateInput()">
                                <h4 class="fw-bold mb-3"><?php echo $result["prd_name"]; ?></h4>
                                <p class="mb-3">ประเภทสินค้า : <?php echo $result["pty_name"] ?></p>
                                <p class="mb-3">มีสินค้าเหลือเพียง : <?php echo $result["prd_amount"]; ?> ชิ้น</p>
                                <h5 class="fw-bold mb-3"><?php echo "ราคา : " . $result["prd_price"] . " บาท" ?></h5>

                                <input type="hidden" id="prd_amount" name="prd_amount" value="<?php echo $result["prd_amount"]; ?>">

                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button type="button" id="btn-minus" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>

                                    <input type="text" name="prd_add_amount" id="prd_add_amount" class="form-control form-control-sm text-center border-0 bg-white" value="1">

                                    <div class="input-group-btn">
                                        <button type="button" id="btn-plus" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <?php if ($result["prd_amount"] > 0) { ?>
                                    <button type="submit" name="btn-add-cart" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                        เพิ่มลงตะกร้า
                                    </button>
                                <?php } else { ?>
                                    <p class="text-danger fw-bold fs-3">*สินค้าหมดแล้ว*</p>
                                <?php } ?>

                            </form>
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" aria-controls="nav-about" aria-selected="true">รายละเอียดสินค้า</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab" id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission" aria-controls="nav-mission" aria-selected="false">ความคิดเห็น</button>
                                </div>
                            </nav>


                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p style="text-align: justify; text-indent: 2em;"><?php echo $result["prd_detail"] ?></p>
                                </div>

                                <!-- Review  -->
                                <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                    <div class="d-flex">
                                        <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Jason Smith</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p>The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <img src="img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Sam Peters</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                            <h4 class="mb-4">สินค้าแนะนำ</h4>

                            <?php foreach ($prd_rec as $prd) { ?>
                                <form action="product_detail.php" method="post">
                                    <button class="border border-0 bg-white" type="submit" name="btn-detail">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <input type="hidden" name="prd_id" value="<?php echo $prd["prd_id"] ?>" readonly>
                                            <div class="rounded" style="width: 100px; height: 100px;">
                                                <img src="uploads/img_product/<?php echo $prd["prd_img_name"] ?>" class="img-fluid rounded w-100" style="height: 90px" alt="">
                                            </div>
                                            <div class="ms-2 text-start">
                                                <h6><?php echo mb_substr($prd["prd_name"], 0, 15, 'utf-8') . (mb_strlen($prd["prd_name"], 'utf-8') > 15 ? '...' : '') ?></h6>
                                                <div class="d-flex mb-2">
                                                    <h5 class="fw-bold me-2"><?php echo $prd["prd_price"] . " บาท" ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">สินค้าที่เกี่ยวข้อง</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">

                    <?php foreach ($prd_new as $prd) { ?>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="uploads/img_product/<?php echo $prd["prd_img_name"] ?>" class="img-fluid w-100 rounded-top" style="height:220px;">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $prd["pty_name"]; ?></div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4 class="text-center"><?php echo mb_substr($prd["prd_name"], 0, 15, 'utf-8') . (mb_strlen($prd["prd_name"], 'utf-8') > 15 ? '...' : '') ?></h4>
                                <div class="d-flex justify-content-center flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold mb-0 text-center"><?php echo $prd["prd_price"] . " บาท" ?></p>
                                </div>
                                <div class="d-flex justify-content-center flex-lg-wrap">
                                    <form action="product_detail.php" method="post">
                                        <input type="hidden" name="prd_id" value="<?php echo $prd["prd_id"] ?>" readonly>
                                        <button type="submit" name="btn-detail" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">
                                            <i class="fa-solid fa-eye"></i>
                                            ดูรายละเอียด
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->


    <!-- Footer Start -->
    <?php require_once("includes/footer.php") ?>
    <?php require_once("includes/vendor.php") ?>

    <!-- ตรวจสอบจำนวนสินค้าก่อน เพิ่มลง cart  -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let btnMinus = document.querySelector('#btn-minus');
            let btnPlus = document.querySelector('#btn-plus');
            let amount = document.getElementById('prd_add_amount');
            let maxAmount = parseInt(document.getElementById('prd_amount').value); // แปลงค่าให้เป็นจำนวนเต็ม


            //  ตรวจสอบค่าที่รับมา
            if (parseInt(amount.value) >= maxAmount) {
                btnPlus.disabled = true;
            }

            // เพิ่มการตรวจสอบเมื่อกดปุ่ม plus
            btnPlus.addEventListener('click', function() {
                if (parseInt(amount.value) >= maxAmount) {
                    btnPlus.disabled = true;
                }
                amount.value = parseInt(amount.value);
                btnMinus.disabled = false; // อนุญาตให้ลดจำนวนได้หลังจากที่กดเพิ่ม
            });

            // เพิ่มการตรวจสอบเมื่อกดปุ่ม minus
            if (parseInt(amount.value) <= 1) {
                btnMinus.disabled = true;
            }

            // เพิ่มการตรวจสอบเมื่อกดปุ่ม Minus
            btnMinus.addEventListener('click', function() {
                if (parseInt(amount.value) - 1 < maxAmount) {
                    btnPlus.disabled = false; // อนุญาตให้เพิ่มจำนวนได้หลังจากที่กดลด
                }
                if (parseInt(amount.value) > 1) {
                    amount.value = parseInt(amount.value);
                }
                if (parseInt(amount.value) === 1) {
                    btnMinus.disabled = true;
                }
            });

            // เพิ่มเหตุการณ์เมื่อมีการเปลี่ยนแปลงในช่อง input
            amount.addEventListener('input', function() {
                // ตรวจสอบว่าค่าที่กรอกเข้ามาเป็นตัวเลขหรือไม่
                if (isNaN(amount.value) || parseInt(amount.value) <= 0 || amount.value.trim() === '') {
                    amount.value = 1; // เปลี่ยนเป็น 1 ถ้าไม่ใช่ตัวเลขหรือเริ่มต้นด้วย 0
                    btnMinus.disabled = false;
                }

                if (parseInt(amount.value) > 1 && parseInt(amount.value) < maxAmount) {
                    btnMinus.disabled = false;
                    btnPlus.disabled = false;
                }

                if (parseInt(amount.value) >= maxAmount) {
                    amount.value = maxAmount; // เปลี่ยนเป็น maxAmount ถ้าเกิน maxAmount
                    btnMinus.disabled = false;
                    btnPlus.disabled = true;
                }
                if (parseInt(amount.value) === 1) {
                    btnMinus.disabled = true;
                    btnPlus.disabled = false;
                }
            });

        });
    </script>


</body>

</html>
<?php require_once("includes/sweetalert2.php") ?>