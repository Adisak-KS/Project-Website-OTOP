<?php
require_once("../db/connect.php");


if (isset($_POST["btn-add"])) {
    $ptyName = $_POST["pty_name"];
    $ptyDetail = $_POST["pty_detail"];

    $location = "Location: product_type_show.php";

    // ตรวจสอบชื่อซ้ำ
    $sql = "SELECT pty_name 
            FROM ot_product_type
            WHERE pty_name = :pty_name
            LIMIT 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":pty_name", $ptyName);
    $stmt->execute();
    $check = $stmt->fetch();

    // พบชื่อซ้ำ
    if ($check) {
        $_SESSION["error"] = "ประเภทสินค้านี้มีอยู่ในระบบแล้ว";
        header($location);
        exit();
    } else {
        // ไม่พบชื่อซ้ำ
        try {

            // Folder เก็บไฟล์
            $dir = "../uploads/img_product_type/";
            $fileDefault = "../uploads/img_product_type/default.png";

            // ตรวจสอบไฟล์
            if (!file_exists($fileDefault)) {
                $_SESSION["error"] = "ไม่พบไฟล์ default.png";
                header($location);
                exit();
            }

            // ไฟล์ defaluft -> สุ่มชื่อ -> นำไปเก็บที่ $pathnewImgProductType
            $nameFileDefault = "default.png";
            $newImgProductType = uniqid('img_', true) . ".png";
            $pathnewImgProductType = $dir . $newImgProductType;


            // คัดลอกไฟล์
            if (copy($fileDefault, $pathnewImgProductType)) {

                // เพิ่มข้อมูล Database
                $sql = "INSERT INTO ot_product_type (pty_img, pty_name, pty_detail)
                        VALUES (:pty_img, :pty_name, :pty_detail)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":pty_img", $newImgProductType);
                $stmt->bindParam(":pty_name", $ptyName);
                $stmt->bindParam(":pty_detail", $ptyDetail);
                $stmt->execute();
            } else {
                $_SESSION["error"] = "คัดลอกรูปภาพไม่สำเร็จ";
                header($location);
                exit();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }


    // ไม่พบ Error
    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "เพิ่มข้อมูลประเภทสินค้าสำเร็จ";
        header($location);
    }
}
