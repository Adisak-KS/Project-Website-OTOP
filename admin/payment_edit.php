<?php
require_once("../db/connect.php");

if (isset($_POST["btn-edit"])) {
    $pmId = $_POST["pm_id"];
    $pmBank = $_POST["pm_bank"];
    $pmName = $_POST["pm_name"];
    $pmNumber = $_POST["pm_number"];
    $pmShow = $_POST["pm_show"];
    $pmQrCode = $_POST["pm_qrCode"];
    $pmNewQrCode = $_FILES["pm_newQrCode"]["tmp_name"];

    $locationSuccess = "Location: payment_show.php";
    $locationError = "Location: payment_edit_form.php";

    try {

        // ตรวจสอบ เลขบัญชีซ้ำ
        $sql = "SELECT pm_number
                FROM ot_payment
                WHERE pm_number = :pm_number AND pm_id != :pm_id
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":pm_number", $pmNumber);
        $stmt->bindParam(":pm_id", $pmId);
        $stmt->execute();
        $check = $stmt->fetch();

        if ($check) {
            $_SESSION["error"] = "มีเลขบัญชีนี้แล้ว";
            header($locationError);
            exit();
        } else {

            $sql = "UPDATE ot_payment
                    SET pm_bank = :pm_bank,
                        pm_name = :pm_name,
                        pm_number = :pm_number,
                        pm_show = :pm_show
                    WHERE pm_id = :pm_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":pm_bank", $pmBank);
            $stmt->bindParam(":pm_name", $pmName);
            $stmt->bindParam(":pm_number", $pmNumber);
            $stmt->bindParam(":pm_show", $pmShow);
            $stmt->bindParam(":pm_id", $pmId);
            $stmt->execute();


            //หากทำการแก้ไขข้อมูลสำเร็จ และ pm_status ที่รับมา เป็น 1 ให้ช่องทางชำระเงินอื่น ๆ เป็น 0
            if ($stmt->rowCount() > 0) {
                if ($pmShow == 1) {
                    $sql = "UPDATE ot_payment
                            SET pm_show = 0
                            WHERE pm_id != :pm_id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":pm_id", $pmId);
                    $stmt->execute();
                }
            }


            // หากมีการ uploads ไฟล์ใหม่
            if (!empty($pmNewQrCode)) {
                // Folder เก็บไฟล์
                $dir = "../uploads/img_payment/";

                // ไฟล์ default -> สุ่มชื่อ -> นำไปเก็บที่ $pathNewQrCode
                $newQrCode = uniqid('qrcode_', true) . ".png";
                $pathNewQrCode = $dir . $newQrCode;

                // ย้ายไฟล์ไปยังโฟลเดอร์ uploads
                if (move_uploaded_file($pmNewQrCode, $pathNewQrCode)) {

                    // ลบไฟล์เก่า (ถ้ามี)
                    $oldFilePath = $dir . $pmQrCode;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }

                    // อัปเดทชื่อไฟล์ใหม่
                    $sql = "UPDATE ot_payment
                            SET pm_qrcode = :pm_qrcode 
                            WHERE pm_id = :pm_id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":pm_qrcode", $newQrCode);
                    $stmt->bindParam(":pm_id", $pmId);
                    $stmt->execute();

                }else{
                    $_SESSION['error'] = "เกิดข้อผิดพลาดในการย้ายไฟล์";
                    header($locationError);
                    exit;
                }
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }


    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "แก้ไขข้อมูลสำเร็จ";
        header($locationSuccess);
    }
}else{
    require_once("includes/no_permission.php");
}
