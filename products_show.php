<?php
$titlePage = "สินค้าทั้งหมด";
require_once("db/connect.php");



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
        <?php if (isset($_POST["pty_id"]) && !empty($result)) { ?>
            <?php $firstPty = reset($result); ?>
            <h1 class="text-center text-white display-6"><?php echo "สินค้าประเภท " . $firstPty["pty_name"]; ?></h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-white"><?php echo $firstPty["pty_name"]; ?></li>
            </ol>
        <?php } else { ?>
            <h1 class="text-center text-white display-6">สินค้าทั้งหมด</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-white">สินค้าทั้งหมด</li>
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

                                            <!-- หากมี Product Type ใน Database ให้แสดง  -->
                                            <?php if (count($result_pty) > 0) { ?>

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

                                            <?php } else { ?>

                                                <!-- หากไม่มี Product Type ใน Database ให้แสดงตัวอย่าง  -->
                                                <?php for ($i = 0; $i < 3; $i++) { ?>
                                                    <li>
                                                        <div class="d-flex justify-content-between fruite-name">
                                                            <button type="submit" name="btn-pty" class="border-0 bg-white" style="color:#81c408;" onmouseover="this.style.color='orange';" onmouseout="this.style.color='#81c408';">
                                                                <i class="fa-solid fa-boxes-stacked"></i>
                                                                ตัวอย่างประเภทสินค้า
                                                            </button>
                                                            <span>(1)</span>
                                                        </div>
                                                    </li>
                                                <?php }  ?>

                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-12">
                                    <h4 class="mb-3">สินค้าแนะนำ</h4>

                                    <!-- หากมี Product ใน Databases ให้แสดง  -->
                                    <?php if (count($prd_rec) > 0) { ?>

                                        <?php foreach ($prd_rec as $prd) { ?>
                                            <form action="product_detail.php" method="post">
                                                <input type="hidden" name="prd_id" value="<?php echo $prd["prd_id"] ?>" readonly>
                                                <button class="border border-0 bg-white" type="submit" name="btn-detail">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <div class="rounded me-4" style="width: 100px; height: 100px;">
                                                            <img src="uploads/img_product/<?php echo $prd["prd_img_name"] ?>" class="img-fluid w-100 rounded" style="height:80px;">
                                                        </div>
                                                        <div class="text-start">
                                                            <h6 class="mb-2"><?php echo mb_substr($prd["prd_name"], 0, 15, 'utf-8') . (mb_strlen($prd["prd_name"], 'utf-8') > 15 ? '...' : '') ?></h6>
                                                            <div class="d-flex mb-2">
                                                                <h5 class="fw-bold me-2"><?php echo $prd["prd_price"] . " บาท"; ?></h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                            </form>
                                        <?php } ?>

                                    <?php } else { ?>

                                        <!-- หากไม่มี Product ใน Database ให้แสดงตัวอย่าง  -->
                                        <?php for ($i = 0; $i < 3; $i++) { ?>
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="rounded me-4" style="width: 100px; height: 100px;">
                                                    <img src="uploads/img_product/default.png" class="img-fluid w-100 rounded" style="height:80px;">
                                                </div>
                                                <div class="text-start">
                                                    <h6 class="mb-2">สินค้าตัวอย่าง</h6>
                                                    <div class="d-flex mb-2">
                                                        <h5 class="fw-bold me-2">100 บาท</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    <?php } ?>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-center">

                                <!-- หากมี Product ใน Database ให้แสดง -->
                                <?php if (count($result) > 0) { ?>

                                    <?php foreach ($result as $prd) { ?>
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

                                <?php } else { ?>

                                    <!-- หากไม่มี Product จาก Database ให้แสดงข้อมูลตัวอย่าง -->
                                    <div class="alert alert-warning text-center" role="alert">
                                        <h4 class="alert-heading">ไม่มีสินค้า !</h4>
                                        <i class="fa-regular fa-face-frown fa-6x my-3"></i>
                                        <p>ไม่มีสินค้าในประเภทนี้ </p>
                                        <hr>
                                        <a href="index.php" class="mt-0 me-5">กลับหน้าหลัก</a>
                                        <a href="products_show.php" class="mt-0">ดูสินค้าอื่น ๆ</a>
                                    </div>
                                <?php } ?>
                            </div>
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