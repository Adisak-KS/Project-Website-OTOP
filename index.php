<?php
require_once("db/connect.php");
$titlePage = "หน้าแรก";


// แสดง Product Type ที่มี pty_show = 1
try {
    $sql = "SELECT * FROM ot_product_type 
            WHERE pty_show = 1 
            ORDER BY RAND() 
            LIMIT 4";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result_pty = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
    return false;
}


// แสดง Product แนะนำ แบบสุ่ม จำนวน 8 รายการ
try {
    $sql = "SELECT * FROM ot_product
            LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
            LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id
            WHERE prd_show = 1 
            ORDER BY RAND() 
            LIMIT 8";
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


    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">รวบรวมสินค้า OTOP มากมาย</h4>
                    <h1 class="mb-5 display-3 text-primary">ของกิน & ของใช้</h1>
                    <div class="position-relative mx-auto">
                        <form action="search_show.php" method="post">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="text" name="prd_name" placeholder="ค้นหาสินค้าที่ต้องการ">
                            <button type="submit" name="btn-search" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">ค้นหา</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">

                            <!-- หากมีข้อมูล Product Type ใน Database ให้แสดง -->
                            <?php if (count($result_pty) > 0) { ?>

                                <?php foreach ($result_pty as $key => $pty) { ?>
                                    <div class="carousel-item <?php echo $key == 0 ? 'active' : ''; ?> rounded">
                                        <img src="uploads/img_product_type/<?php echo $pty["pty_img"] ?>" class="img-fluid bg-secondary rounded w-100" style="height: 350px;" alt="Image of <?php echo $pty["pty_name"]; ?>">
                                        <a href="#" class="btn px-4 py-2 text-white rounded"><?php echo $pty["pty_name"]; ?></a>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>

                                <!-- ไม่มีข้อมูล Product Type ใน Database ให้แสดงตัวอย่าง -->
                                <div class="carousel-item active rounded">
                                    <img src="uploads/img_product_type/default.png" class="img-fluid bg-secondary rounded w-100" style="height: 350px;" alt="First slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">รูปตัวอย่าง</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="uploads/img_product_type/default.png" class="img-fluid bg-secondary rounded w-100" style="height: 350px;" alt="First slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">รูปตัวอย่าง</a>
                                </div>

                            <?php } ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- Featurs Section Start -->
    <div class="container-fluid featurs py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>ส่งทั่วไทย</h5>
                            <p class="mb-0">ราคา 50 บาท/รายการ เท่านั้น</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>ชำระเงินปลอดภัย</h5>
                            <p class="mb-0">100% ชำระเงินปลอดภัย</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>คืนสินค้าได้ใน 30 วัน</h5>
                            <p class="mb-0">รับประกันสินค้า 30 วัน</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>ดูแล 24/7</h5>
                            <p class="mb-0">ดูแลด้วยความใส่ใจ รวดเร็ว</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featurs Section End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>ซื้ออะไรดี ?</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">สินค้าแนะนำ</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <!-- หากมีข้อมูล Product แนะนำ ใน Database ให้แสดง  -->
                                    <?php if (count($prd_rec) > 0) { ?>

                                        <?php foreach ($prd_rec as $prd) { ?>
                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <img src="uploads/img_product/<?php echo $prd["prd_img_name"]; ?>" class="img-fluid w-100 rounded-top" style="height:220px;">
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $prd["pty_name"] ?></div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4><?php echo mb_substr($prd["prd_name"], 0, 15, 'utf-8') . (mb_strlen($prd["prd_name"], 'utf-8') > 15 ? '...' : '') ?></h4>

                                                        <div class="d-flex justify-content-center flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0 text-center"><?php echo $prd["prd_price"] . " บาท" ?></p>
                                                        </div>
                                                        <div class="d-flex justify-content-center flex-lg-wrap">
                                                            <form action="product_detail.php" method="post">
                                                                <input type="hidden" name="prd_id" value="<?php echo $prd["prd_id"] ?>" readonly>
                                                                <button type="submit" name="btn-detail" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                    ดูรายละเอียด
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    <?php } else { ?>
                                        <!-- หากไม่มีข้อมูล Product แนะนำ ใน Database ให้แสดงตัวอย่าง  -->
                                        <?php for ($i = 0; $i < 8; $i++) { ?>
                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <img src="uploads/img_product/default.png" class="img-fluid w-100 rounded-top" style="height:220px;">
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">ประเภทสินค้า</div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4>สินค้าตัวอย่าง</h4>
                                                        <p style="height: 40px;">สินค้าตัวอย่าง สำหรับแสดงเค้าโครงหน้าเว็บไซต์</p>
                                                        <div class="d-flex justify-content-center flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0 text-center">100 บาท</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center flex-lg-wrap">
                                                            <button type="submit" name="btn-detail" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                <i class="fa-solid fa-eye"></i>
                                                                ดูรายละเอียด
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->



    <!-- Vesitable Shop Start-->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0">สินค้าใหม่</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <!-- หากมี Product ใหม่ ใน Database ให้แสดง  -->
                <?php if (count($prd_new) > 0) { ?>

                    <?php foreach ($prd_new as $prd) { ?>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="uploads/img_product/<?php echo $prd["prd_img_name"]; ?>" class="img-fluid w-100 rounded-top" style="height:220px;">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $prd["pty_name"]; ?></div>
                            <div class="p-4 rounded-bottom">
                            <h4 class="text-center"><?php echo mb_substr($prd["prd_name"], 0, 15, 'utf-8') . (mb_strlen($prd["prd_name"], 'utf-8') > 15 ? '...' : '') ?></h4>
                                <div class="d-flex justify-content-center flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold mb-0 text-center"><?php echo $prd["prd_price"] . " บาท" ?></p>
                                </div>
                                <div class="d-flex justify-content-center flex-lg-wrap">
                                    <form action="product_detail.php" method="post">
                                        <input type="hidden" name="prd_id" value="<?php echo $prd["prd_id"] ?>" readonly>
                                        <button type="submit" name="btn-detail" class="btn border border-secondary rounded-pill px-3 text-primary">
                                            <i class="fa-solid fa-eye"></i>
                                            ดูรายละเอียด
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                <?php } else { ?>
                    <!-- หากไม่มี Product ใหม่ ใน Database ให้แสดงตัวอย่าง  -->
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="uploads/img_product/default.png" class="img-fluid w-100 rounded-top" style="height:220px;">
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">ประเภทสินค้า</div>
                            <div class="p-4 rounded-bottom">
                                <h4 class="text-center">สินค้าตัวอย่าง</h4>
                                <p class="text-center" style="height: 40px;">สินค้าตัวอย่าง สำหรับแสดงเค้าโครงหน้าเว็บไซต์</p>
                                <div class="d-flex justify-content-center flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold mb-0 text-center">100 บาท</p>
                                </div>
                                <div class="d-flex justify-content-center flex-lg-wrap">
                                    <button type="submit" name="btn-detail" class="btn border border-secondary rounded-pill px-3 text-primary">
                                        <i class="fa-solid fa-eye"></i>
                                        ดูรายละเอียด
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                <?php } ?>
            </div>
        </div>
        <!-- Vesitable Shop End -->

        <!-- Footer Start -->
        <?php require_once("includes/footer.php") ?>
        <?php require_once("includes/vendor.php") ?>
</body>

</html>
<!-- Sweetalert2 แจ้งเตือนจาก php  -->
<?php require_once("includes/sweetalert2.php");
