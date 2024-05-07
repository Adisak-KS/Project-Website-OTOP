<?php
require_once("../db/connect.php");


if (isset($_POST["btn-add"])) {
    $prdName = $_POST["prd_name"];
    $prdPrice = $_POST["prd_price"];
    $prdAmount = $_POST["prd_amount"];
    $ptyId = $_POST["pty_id"];

    $location = "Location: product_show.php";

    // ตรวจสอบ Username และ Email ซ้ำ
    $sql = "SELECT prd_name 
            FROM ot_product
            WHERE prd_name = :prd_name
            LIMIT 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":prd_name", $prdName);
    $stmt->execute();
    $check = $stmt->fetch();

    // พบ Product Name ซ้ำ 
    if ($check) {
        $_SESSION["error"] = "ชื่อสินค้านี้มีอยู่ในระบบแล้ว";
        header($location);
        exit();
    } else {
        try {

            // เพิ่มข้อมูล Database
            $sql = "INSERT INTO ot_product (prd_name, prd_price, prd_amount, pty_id)
                    VALUES (:prd_name, :prd_price, :prd_amount, :pty_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":prd_name", $prdName);
            $stmt->bindParam(":prd_price", $prdPrice);
            $stmt->bindParam(":prd_amount", $prdAmount);
            $stmt->bindParam(":pty_id", $ptyId);
            $stmt->execute();

            // เก็บ ID ล่าสุดที่เพิ่มเข้าไป
            $lastInsertedId = $conn->lastInsertId();

            // Folder เก็บไฟล์
            $dir = "../uploads/img_product/";
            $fileDefault = "../uploads/img_product/default.png";

            // ตรวจสอบไฟล์ default
            if (!file_exists($fileDefault)) {
                $_SESSION["error"] = "ไม่พบไฟล์ default.png";
                header($location);
                exit();
            }

            // ไฟล์ defaluft -> สุ่มชื่อ -> นำไปเก็บที่ $pathNewProfile
            $nameFileDefault = "default.png";
            $newImg = uniqid('prd_', true) . ".png"; // นำไปใช้
            $pathNewProfile = $dir . $newImg;

            // คัดลอกไฟล์
            if (copy($fileDefault, $pathNewProfile)) {

                // เพิ่มข้อมูลรูปภาพใหม่ลงในตาราง ot_product_img
                $sql_img = "INSERT INTO ot_product_img (prd_id, prd_img_name) 
                            VALUES (:prd_id, :prd_img_name)";
                $stmt_img = $conn->prepare($sql_img);
                $stmt_img->bindParam(":prd_id", $lastInsertedId);
                $stmt_img->bindParam(":prd_img_name", $newImg);
                $stmt_img->execute();
            } else {
                $_SESSION["error"] = "คัดลอกรูปภาพไม่สำเร็จ";
                header($location);
                exit();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // ไม่พบ Error
    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "เพิ่มข้อมูลสินค้าสำเร็จ";
        header($location);
    }
}
