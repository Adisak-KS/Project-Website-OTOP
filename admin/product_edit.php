<?php
require_once("../db/connect.php");


if (isset($_POST["btn-edit"])) {
    // รับค่าที่ส่งมาจากฟอร์ม
    $prdId = $_POST["prd_id"];
    $prdName = $_POST["prd_name"];
    $prdPrice = $_POST["prd_price"];
    $prdAmount = $_POST["prd_amount"];
    $prdDetail = $_POST["prd_detail"];
    $ptyId = $_POST["pty_id"];
    $prdShow = $_POST["prd_show"];
    $prdImg = $_POST["prd_img"];
    $prdNewImg = $_FILES["prd_newImg"]["tmp_name"];

    $locationSuccess = "Location: product_show.php";
    $locationError = "Location: product_edit_form.php";

    // ตรวจสอบว่าชื่อซ้ำหรือไม่
    $sql = "SELECT prd_id, prd_name 
            FROM ot_product 
            WHERE prd_name = :prd_name AND prd_id != :prd_id
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":prd_name", $prdName);
    $stmt->bindParam(":prd_id", $prdId);
    $stmt->execute();
    $check = $stmt->fetch();

    // หากพบชื่อซ้ำ
    if ($check) {
        $_SESSION["error"] = "ชื่อสินค้านี้มีอยู่แล้วในระบบ";
        header($locationError);
        exit;
    } else {
        // ไม่พบขื่อซ้อ
        try {
            $sql = "UPDATE ot_product
                    SET prd_name = :prd_name, 
                        prd_price = :prd_price, 
                        prd_amount = :prd_amount, 
                        prd_detail = :prd_detail, 
                        pty_id = :pty_id, 
                        prd_show = :prd_show 
                    WHERE prd_id = :prd_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":prd_name", $prdName);
            $stmt->bindParam(":prd_price", $prdPrice);
            $stmt->bindParam(":prd_amount", $prdAmount);
            $stmt->bindParam(":prd_detail", $prdDetail);
            $stmt->bindParam(":pty_id", $ptyId);
            $stmt->bindParam(":prd_show", $prdShow);
            $stmt->bindParam(":prd_id", $prdId);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }


    // อัพโหลดรูปใหม่ (ถ้ามี)
    if (!empty($prdNewImg)) {
        // โฟลเดอร์ที่เก็บไฟล์
        $dir = "../uploads/img_product/";

        // สร้างชื่อไฟล์ใหม่และเส้นทาง
        $newImg = uniqid('prd_', true) . ".png";
        $pathNewImg = $dir . $newImg;

        // ย้ายไฟล์ไปยังโฟลเดอร์ uploads
        if (move_uploaded_file($prdNewImg, $pathNewImg)) {

            // ลบไฟล์เก่า (ถ้ามี)
            $oldFilePath = $dir . $prdImg;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            try {
                $sql = "UPDATE ot_product_img
                        SET prd_img_name = :prd_img_name 
                        WHERE prd_id = :prd_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":prd_img_name", $newImg);
                $stmt->bindParam(":prd_id", $prdId);
                $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                return false;
            }
        } else {
            $_SESSION['error'] = "เกิดข้อผิดพลาดในการย้ายไฟล์";
            header($locationError);
            exit;
        }
    }

    // ล้าง session และกลับไปยังหน้าที่กำหนด
    if (empty($_SESSION["error"])) {
        unset($_SESSION["prd_id"]);
        $_SESSION["success"] = "แก้ไขข้อมูลสินค้าสำเร็จ";
        header($locationSuccess);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
