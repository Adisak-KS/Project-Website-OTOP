<?php
require_once("../db/connect.php");

if (isset($_POST["btn-add"])) {

    $pmBank = $_POST["pm_bank"];
    $pmName = $_POST["pm_name"];
    $pmNumber = $_POST["pm_number"];

    $location = "Location: payment_show.php";

    try {
        $sql = "SELECT pm_number
                FROM ot_payment
                WHERE pm_number = :pm_number
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pm_number", $pmNumber);
        $stmt->execute();
        $check = $stmt->fetch();


        if ($check) {
            $_SESSION["error"] = "มีหมายเลขบัญชีนี้แล้ว";
            header($location);
            exit();
        } else {

            // Folder เก็บไฟล์
            $dir = "../uploads/img_payment/";
            $fileDefault = "../uploads/img_payment/default.png";

            // ตรวจสอบไฟล์
            if (!file_exists($fileDefault)) {
                $_SESSION["error"] = "ไม่พบไฟล์ default.png";
                header($location);
                exit();
            }

            // ไฟล์ default -> สุ่มชื่อ -> นำไปเก็บที่ $pathNewQrCode
            $newQrCode = uniqid('qrcode_', true) . ".png";
            $pathNewQrCode = $dir . $newQrCode;

            // คัดลอกไฟล์
            if (copy($fileDefault, $pathNewQrCode)) {
                // เพิ่มข้อมูลในฐานข้อมูล
                $sql = "INSERT INTO ot_payment (pm_qrcode, pm_bank, pm_name, pm_number)
                        VALUES (:pm_qrcode, :pm_bank, :pm_name, :pm_number)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":pm_qrcode", $newQrCode);
                $stmt->bindParam(":pm_bank", $pmBank);
                $stmt->bindParam(":pm_name", $pmName);
                $stmt->bindParam(":pm_number", $pmNumber);
                $stmt->execute();
            } else {
                $_SESSION["error"] = "คัดลอกรูปภาพไม่สำเร็จ";
                header($location);
                exit();
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }


    if(empty($_SESSION["error"])){
        $_SESSION["success"]= "เพิ่มข้อมูลสำเร็จ";
        header($location);
    }
}else{
    require_once("includes/no_permission.php");
}
