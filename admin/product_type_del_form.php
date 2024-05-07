<?php
require_once("../db/connect.php");

$titlePage = "ลบข้อมูลประเภทสินค้า";

// รับ id
if (isset($_POST["btn-del"]) && isset($_POST["pty_id"])) {
    $ptyId = $_POST["pty_id"];
    $_SESSION["pty_id"] = $ptyId; // เก็บค่า ID ใน session
    try {
        $sql = "SELECT * 
                FROM ot_product_type 
                WHERE pty_id = :pty_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pty_id", $ptyId);
        $stmt->execute();
        $result = $stmt->fetch();

    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} elseif (isset($_SESSION["pty_id"])) {
    $ptyId = $_SESSION["pty_id"];
    try {
        $sql = "SELECT * 
            FROM ot_product_type 
            WHERE pty_id = :pty_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pty_id", $ptyId);
        $stmt->execute();
        $result = $stmt->fetch();
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
} else {
    header("Location:product_type_show.php");
}

//ไม่มีข้อมูลให้กลับ
if (!$result) {
    header("Location:product_type_show.php");
}

// แสดง product ที่อยู่ใน Product Type  มีกี่รายการตาม $ptyId (ใกล้ปุ่มลบ)
try {
    $sql = "SELECT COUNT(*) 
            AS product_count 
            FROM ot_product 
            WHERE pty_id = :pty_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":pty_id", $ptyId);
    $stmt->execute();
    $productCountResult = $stmt->fetch();
    $productCount = $productCountResult['product_count'];
} catch (Exception $e) {
    echo $e->getMessage();
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
                <form id="form" action="product_type_del.php" method="post">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            ข้อมูลทั่วไป
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pty_id">รหัสประเภทสินค้า : </label>
                                            <input class="form-control" type="text" name="pty_id" value="<?php echo $result["pty_id"]; ?>" readonly>
                                        </div>
                                        <div class=" form-group mb-3">
                                            <label class="form-label" for="pty_name">ชื่อประเภทสินค้า : </label><span class="text-danger">*</span>
                                            <input class="form-control" type="text" name="pty_name" placeholder="กรุณากรอก ชื่อประเภทสินค้า" value="<?php echo $result["pty_name"] ?>" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pty_detail">รายละเอียด : </label><span class="text-danger">*</span>
                                            <textarea class="form-control" name="pty_detail" rows="4" placeholder="กรุณากรอก รายบะเอียดประเภทสินค้า" disabled><?php echo $result["pty_detail"] ?></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="pty_show">การแสดงประเภทสินค้า : </label>
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input custom-control-input-success" type="radio" id="show" name="pty_show" value="1" <?php if ($result["pty_show"] == "1") echo "checked"; ?> disabled>
                                                <label for="show" class="custom-control-label">แสดงประเภทสินค้า</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <!-- หากการแสดงสินค่ามีค่า = 0 หรือ มีค่าไม่ใช่เลข 1 ให้ checked  -->
                                                <input class="custom-control-input custom-control-input-danger" type="radio" id="hide" name="pty_show" value="0" <?php if ($result["pty_show"] == "0" || $result["pty_show"] != "1") echo "checked"; ?> disabled>
                                                <label for="hide" class="custom-control-label">ไม่แสดงประเภทสินค้า</label>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-6">
                                <div class="card card-danger pb-5">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            รูปภาพประเภทสินค้า
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="pty_img">รูปภาพประเภทสินค้า : </label>
                                            <br>
                                            <img class="mx-auto d-block border" style="width:150px; height:150px" id="pty_img" name="pty_img" src="../uploads/img_product_type/<?php echo $result["pty_img"]; ?>">
                                            <input class="form-control" type="hidden" name="pty_img" value="<?php echo $result["pty_img"]; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <div class="col-md-12">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fa-solid fa-trash"></i>
                                            จัดการข้อมูล
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <style>
                                            a.disabled {
                                                pointer-events: none;
                                                color: #ccc;
                                            }
                                        </style>
                                        <?php if ($productCount > 0) { ?>
                                            <!-- Product > 0 ให้แสดง -->
                                            <p class="text-danger">มีสินค้าในประเภทนี้ทั้งหมด <?php echo $productCount; ?> รายการ ที่จำเป็นต้องลบก่อน <a href="product_show.php">ดูสินค้าที่นี่</a></p>
                                            <div class="form-group mb-3">
                                                <a href="product_type_show.php" class="btn btn-secondary" type="button">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    ยกเลิก
                                                </a>
                                                <!-- ส่ง pty_id และ pty_img  --> <!-- เพิ่มเงื่อนไขเพื่อใส่ CSS คลาส "disabled" เฉพาะเมื่อมีสินค้า > 0 -->
                                                <a class="btn btn-danger disabled">
                                                    <i class="fa-solid fa-trash"></i>
                                                    ลบข้อมูล
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <p>ไม่พบสินค้าในรายการประเภทนี้ สามารถลบได้เลย</p>
                                            <div class="form-group mb-3">
                                                <a href="product_type_show.php" class="btn btn-secondary" type="button">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    ยกเลิก
                                                </a>
                                                <!-- ส่ง pty_id และ pty_img  -->
                                                <a data-pty_id="<?php echo $result["pty_id"]; ?>" data-pty_img="<?php echo $result["pty_img"]; ?>" class="btn btn-danger btn-delete" name="btn-del">
                                                    <i class="fa-solid fa-trash"></i>
                                                    ลบข้อมูล
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

    <script>
        $(".btn-delete").click(function(e) {
            e.preventDefault();
            let ptyId = $(this).data('pty_id');
            let ptyImg = $(this).data('pty_img');

            deleteConfirm(ptyId, ptyImg);
        });

        function deleteConfirm(ptyId, ptyImg) {
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
                                url: 'product_type_del.php',
                                type: 'POST',
                                data: {
                                    pty_id: ptyId,
                                    pty_img: ptyImg
                                },
                            })
                            .done(function() {
                                // การลบสำเร็จ ทำการ redirect ไปยังหน้า product_type_show.php
                                document.location.href = 'product_type_show.php';
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
<?php require_once("includes/sweetalert2.php"); ?>