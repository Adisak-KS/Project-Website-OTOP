<?php
require_once("db/connect.php");

if (isset($_POST["btn-add-slip"])) {
    $ordId = $_SESSION["ord_id"];
    $_SESSION["ord_id"] = $ordId;

    $cartNetPrice = $_SESSION["netPrice"];


    $ordImgSlip = $_FILES["ord_slip_img"]['tmp_name'];


    $dir = "uploads/img_slip/";

    // สุ่มชื่อ
    $newImgSlip = uniqid('slip_', true) . ".png";
    $pathNewImgSlip = $dir . $newImgSlip;


    // ย้ายไฟล์
    if (move_uploaded_file($ordImgSlip, $pathNewImgSlip)) {

        try {
            $sql = "INSERT INTO ot_order_slip (ord_id, ord_slip_img)
                    VALUES (:ord_id, :ord_slip_img)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("ord_id", $ordId);
            $stmt->bindParam(":ord_slip_img", $newImgSlip);
            $stmt->execute();



            $sql = "UPDATE ot_order 
                    SET cart_net_price = :cart_net_price, 
                        ord_status = 'รอตรวจสอบ'
                    WHERE ord_id = :ord_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":cart_net_price", $cartNetPrice);
            $stmt->bindParam(":ord_id", $ordId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    } else {
        $_SESSION["error"] = "ย้ายไฟล์ไม่สำเร็จ";
        header("Location: slip_form.php");
        exit();
    }


    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "สั่งซื้อสินค้าเสร็จสิ้น";
        header("Location: my_account_history");
    }
} else {
    require_once("includes/permission.php");
}
