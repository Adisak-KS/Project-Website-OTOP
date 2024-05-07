<?php
require_once("../db/connect.php");

if (isset($_POST["pm_id"])) {
    $pmId = $_POST["pm_id"];
    $pmQrCode = $_POST["pm_qrcode"];


    $locationSuccess = "refresh:1; url=payment_show.php";
    $locationError = "refresh:1; url=payment_edit_form.php";

    if ($pmId) {

        try {

            // Folder เก็บไฟล์
            $dir = "../uploads/img_payment/";

            // ลบไฟล์เก่า (ถ้ามี)
            $oldFilePath = $dir . $pmQrCode;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // ลบข้อมูล
            $sql = "DELETE FROM ot_payment
                    WHERE pm_id = :pm_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":pm_id", $pmId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // ไม่พบ Error
    if (empty($_SESSION['error'])) {
        $_SESSION['success'] = "ลบข้อมูลช่องทางขำระเงินสำเร็จ";
        header($location);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
