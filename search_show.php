<?php
$titlePage = "ข้อมูลการค้นหา";
require_once("db/connect.php");



// แสดงข้อมูลการค้นหา
if (isset($_POST['btn-search']) && !empty($_POST['prd_name'])) {
    // รับค่าที่ผู้ใช้ป้อนเข้ามา
    $prdName = $_POST['prd_name'];

    try {
        $sql = "SELECT * 
        FROM ot_product 
        LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id 
        LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id 
        WHERE prd_name LIKE :prd_name AND prd_show = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":prd_name", "%$prdName%", PDO::PARAM_STR);
        $stmt->execute();
        $result_search = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location: index.php");
    exit();
}


// แสดง Product ตาม pty_id ที่ผู้ใช้เลือก โดยมี prd_show = 1 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pty_id"])) {
    $ptyId = $_POST["pty_id"];

    try {
        $sql = "SELECT * FROM ot_product
                LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
                LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id
                WHERE prd_show = 1 AND ot_product.pty_id = :pty_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pty_id", $ptyId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    // แสดง Product ทั้งหมด ที่มี prd_show = 1 
    try {
        $sql = "SELECT * FROM ot_product
                LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
                LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id
                WHERE prd_show = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}



// แสดง Product Type ทั้งหมดที่มี pty_show = 1 และมีสินค้ากี่ชิ้น
try {
    $sql = "SELECT ot_product_type.pty_id, ot_product_type.pty_name, 
            COUNT(ot_product.pty_id) AS prd_count
            FROM ot_product_type
            LEFT JOIN ot_product ON ot_product_type.pty_id = ot_product.pty_id AND ot_product.prd_show = 1
            WHERE ot_product_type.pty_Show = 1
            GROUP BY ot_product_type.pty_id, ot_product_type.pty_name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result_pty = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
    return false;
}



// แสดง Product แนะนำ แบบสุ่ม จำนวน 3 รายการ
try {
    $sql = "SELECT * FROM ot_product
            LEFT JOIN ot_product_img ON ot_product.prd_id = ot_product_img.prd_id
            LEFT JOIN ot_product_type ON ot_product.pty_id = ot_product_type.pty_id
            WHERE prd_show = 1 
            ORDER BY RAND() 
            LIMIT 3";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $prd_rec = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <?php if (isset($_POST["pty_id"])) { ?>
            <?php $firstPty = reset($result); ?>
            <h1 class="text-center text-white display-6"><?php echo "สินค้าประเภท " . $firstPty["pty_name"]; ?></h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="#"><?php echo $firstPty["pty_name"]; ?></a></li>
            </ol>
        <?php } else { ?>
            <h1 class="text-center text-white display-6">ผลการค้นหาสินค้า</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-white">ผลการค้นหาสินค้า</li>
            </ol>
        <?php } ?>


    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <h1 class="mb-4">OTOP-SHOP</h1>
                            <!-- <div class="input-group w-100 mx-auto d-flex">
                                <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div> -->
                        </div>
                        <div class="col-6"></div>

                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>ประเภทสินค้า</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            <?php foreach ($result_pty as $pty) { ?>
                                                <form action="products_show.php" method="post">
                                                    <input type="hidden" name="pty_id" value="<?php echo $pty["pty_id"] ?>" readonly>
                                                    <li>
                                                        <div class="d-flex justify-content-between fruite-name">
                                                            <button type="submit" name="btn-pty" class="border-0 bg-white" style="color:#81c408;" onmouseover="this.style.color='orange';" onmouseout="this.style.color='#81c408';">
                                                                <i class="fa-solid fa-boxes-stacked"></i>
                                                                <?php echo $pty["pty_name"]; ?>
                                                            </button>
                                                            <span>(<?php echo $pty["prd_count"] ?>)</span>
                                                        </div>
                                                    </li>
                                                </form>
                                            <?php } ?>
                                        </ul>
                                        <!-- <ul class="list-unstyled fruite-categorie">
                                            <?php foreach ($result_pty as $pty) { ?>
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="#">
                                                            <i class="fas fa-apple-alt me-2"></i>
                                                            
                                                            <?php echo $pty["pty_name"]; ?>
                                                        </a>
                                                        <span>(<?php echo $pty["prd_count"] ?>)</span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul> -->
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-12">
                                    <h4 class="mb-3">สินค้าแนะนำ</h4>
                                    <?php foreach ($prd_rec as $prd) { ?>
                                        <form action="product_detail.php" method="post">
                                            <button class="border border-0 bg-white" type="submit" name="btn-detail">
                                                <div class="d-flex align-items-center justify-content-start">
                                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                                        <img src="uploads/img_product/<?php echo $prd["prd_img_name"] ?>" class="img-fluid w-100 rounded" style="height:80px;">
                                                    </div>
                                                    <div class="text-start">
                                                        <h6 class="mb-2"><?php echo mb_substr($prd["prd_name"], 0, 15, 'utf-8') . (mb_strlen($prd["prd_name"], 'utf-8') > 15 ? '...' : '') ?></h6>
                                                        <!-- <div class="d-flex mb-2">
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star"></i>
                                                        </div> -->
                                                        <div class="d-flex mb-2">
                                                            <h5 class="fw-bold me-2"><?php echo $prd["prd_price"] . " บาท"; ?></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                        </form>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                        <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <!-- หากมีข้อมูลที่ตรงกับการค้นหา -->
                            <?php if (count($result_search) > 0) { ?>
                                <div class="row g-4 justify-content-center">
                                    <?php foreach ($result_search as $prd) { ?>
                                        <div class="col-md-6 col-lg-6 col-xl-4">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="uploads/img_product/<?php echo $prd["prd_img_name"]; ?>" class="img-fluid w-100 rounded-top" style="height:220px;">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $prd["pty_name"] ?></div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4 class="text-center"><?php echo mb_substr($prd["prd_name"], 0, 15, 'utf-8') . (mb_strlen($prd["prd_name"], 'utf-8') > 15 ? '...' : '') ?></h4>
                                                    <div class="d-flex justify-content-center flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0"><?php echo $prd["prd_price"] . " บาท" ?></p>
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

                                    <!-- <div class="col-12">
                                    <div class="pagination d-flex justify-content-center mt-5">
                                        <a href="#" class="rounded">&laquo;</a>
                                        <a href="#" class="active rounded">1</a>
                                        <a href="#" class="rounded">2</a>
                                        <a href="#" class="rounded">3</a>
                                        <a href="#" class="rounded">4</a>
                                        <a href="#" class="rounded">5</a>
                                        <a href="#" class="rounded">6</a>
                                        <a href="#" class="rounded">&raquo;</a>
                                    </div>
                                </div> -->
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-warning text-center" role="alert">
                                    <h4 class="alert-heading">ไม่พบข้อมูลที่ค้นหา !</h4>
                                    <i class="fa-regular fa-face-frown fa-6x my-3"></i>
                                    <p><?php echo "คำค้นหา : " . $_POST['prd_name'] ?></p>
                                    <p>ไม่พบข้อมูลตามที่ท่านค้นหา กรุณาลองใช้คำค้นหาอื่น ๆ </p>
                                    <hr>
                                    <a href="index.php" class="mt-0">กลับหน้าหลัก</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->


    <!-- Footer Start -->
    <?php require_once("includes/footer.php") ?>
    <?php require_once("includes/vendor.php") ?>
</body>

</html>