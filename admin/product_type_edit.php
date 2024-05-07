<?php
require_once("../db/connect.php");


if (isset($_POST["btn-edit"])) {
    // รับค่าที่ส่งมาจากฟอร์ม
    $ptyId = $_POST["pty_id"];
    $ptyName = $_POST["pty_name"];
    $ptyDetail = $_POST["pty_detail"];
    $ptyShow = $_POST["pty_show"];
    $ptyImg = $_POST["pty_img"];
    $ptyNewImg =  $_FILES["pty_newImg"]["tmp_name"];

    $locationSuccess = "Location: product_type_show.php";
    $locationError = "Location: product_type_edit_form.php";

    // ตรวจสอบว่าชื่อซ้ำหรือไม่
    $sql = "SELECT pty_id, pty_name 
            FROM ot_product_type 
            WHERE pty_name = :pty_name AND pty_id != :pty_id
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":pty_name", $ptyName);
    $stmt->bindParam(":pty_id", $ptyId);
    $stmt->execute();
    $check = $stmt->fetch();

    // พบชื่อซ้ำ
    if ($check) {
        // ถ้าพบชื่อซ้ำในฐานข้อมูล
        $_SESSION["error"] = "ชื่อประเภทสินค้านี้มีอยู่แล้วในระบบ";
        header($locationError);
        exit;
    } else {
        // ไม่พบชื่อซ้ำ
        try {
            $sql = "UPDATE ot_product_type 
                    SET pty_name = :pty_name, 
                        pty_detail = :pty_detail, 
                        pty_show = :pty_show 
                    WHERE pty_id = :pty_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":pty_name", $ptyName);
            $stmt->bindParam(":pty_detail", $ptyDetail);
            $stmt->bindParam(":pty_show", $ptyShow);
            $stmt->bindParam(":pty_id", $ptyId);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    
    // อัพโหลดรูปใหม่ (ถ้ามี)
    if (!empty($ptyNewImg)) {
        // โฟลเดอร์ที่เก็บไฟล์
        $dir = "../uploads/img_product_type/";

        // สร้างชื่อไฟล์ใหม่และเส้นทาง
        $newImg = uniqid('img_', true) . ".png";
        $pathNewImg = $dir . $newImg;

        // ย้ายไฟล์ไปยังโฟลเดอร์ปลายทาง
        if (move_uploaded_file($ptyNewImg, $pathNewImg)) {

            // ลบไฟล์เก่า (ถ้ามี)
            $oldFilePath = $dir . $ptyImg;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            try {
                // อัพเดทชื่อไฟล์ในฐานข้อมูล
                $sql = "UPDATE ot_product_type 
                        SET pty_img = :pty_img 
                        WHERE pty_id = :pty_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":pty_img", $newImg);
                $stmt->bindParam(":pty_id", $ptyId);
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

    // ไม่มี Error
    if (empty($_SESSION["error"])) {
        // ล้าง session และกลับไปยังหน้าที่กำหนด
        unset($_SESSION["pty_id"]);
        $_SESSION["success"] = "แก้ไขข้อมูลประเภทสินค้าสำเร็จ";
        header($locationSuccess);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
