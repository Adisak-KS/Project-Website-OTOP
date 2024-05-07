<?php
$totalQuantity = 0;


if (isset($_SESSION['mem_id'])) {
    $memId =  $_SESSION['mem_id'];

    try {
        $sql = "SELECT mem_id, mem_fname, mem_lname, mem_username
                FROM ot_member 
                WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":mem_id", $memId);
        $stmt->execute();
        $result_use = $stmt->fetch();

        if ($result_use) {
            $sql = "SELECT SUM(cart_quantity) AS totalQuantity FROM ot_cart WHERE mem_id = :mem_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":mem_id", $memId);
            $stmt->execute();
            $totalQuantity = $stmt->fetchColumn();
        } else {
            // ทำลาย session
            session_destroy();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

?>


<!-- Spinner Start -->
<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
<!-- Spinner End -->


<!-- Navbar start -->
<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="mx-1"><i class="fa-solid fa-location-dot text-white"></i></small><a href="https://maps.app.goo.gl/YSPnbRnNxNFkJphYA" class="text-white">มหาวิทยาลัยเทคโนโลยีราชมงคลรัตนโกสินทร์ วิทยาเขตวังไกลกังวล</a></small>
                <small class="ms-2"><i class="fa-solid fa-envelope text-white"></i><a href="#" class="text-white">Adisak.General@gmail.com</a></small>
            </div>
            <div class="top-link pe-2">
                <!-- <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a> -->

                <!-- // มีการ login เข้ามาหรือไม่ -->
                <?php if (isset($_SESSION["mem_id"]) && $result_use !== false) { ?>
                    <a href="contact.php" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                    <a href="contact.php" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                    <small class="text-white mx-2"><?php echo "สวัสดีคุณ " . $result_use["mem_fname"] . " " . $result_use["mem_lname"]  ?></small>
                <?php } else { ?>
                    <a href="login_form.php" class="text-white"><small class="text-white ms-2">สมัครสมาชิก / เข้าสู่ระบบ</small></a>
                <?php } ?>
                
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="index.php" class="navbar-brand">
                <h1 class="text-primary display-6">OTOP-SHOP</h1>
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="index.php" class="nav-item nav-link active">หน้าแรก</a>
                    <a href="products_show.php" class="nav-item nav-link">สินค้าทั้งหมด</a>
                    <a href="contact.php" class="nav-item nav-link">ติดต่อเรา</a>
                </div>
                <div class="d-flex m-3 me-0">
                    <a href="cart_show.php" class="position-relative me-4 my-auto">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                        <?php if ($totalQuantity > 0) { ?>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?php echo $totalQuantity; ?></span>
                        <?php } ?>
                    </a>


                    <?php if (isset($_SESSION["mem_id"]) && $result_use !== false) { ?>

                        <li style="list-style-type: none;" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                                <?php echo $result_use["mem_username"] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="my_account_setting.php">จัดการกับบัญชีของฉัน</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->