<?php
require_once("../db/connect.php");
require_once("includes/verify_admin.php");


// ตรวจสอบว่ามีการส่งค่า delete มาหรือไม่
if (isset($_POST['adm_id'])) {
    // ตรวจสอบค่าที่ส่งเข้ามาเพื่อป้องกัน SQL Injection
    $admId = filter_input(INPUT_POST, 'adm_id', FILTER_VALIDATE_INT);
    $admProfile = $_POST['adm_profile'];

    $locationSuccess = "refresh:1; url=admin_show.php";
    $locationError = "refresh:1; url=admin_del_form.php";

    if ($admId !== false) {
        // เตรียมคำสั่ง SQL และทำการลบข้อมูล
        $sql = "DELETE FROM ot_admin 
                WHERE adm_id = :adm_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':adm_id', $admId);
        $stmt->execute();

        // ตรวจสอบว่าลบข้อมูลสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {

            // ลบไฟล์เดิม (ถ้ามี)
            $dir = "../uploads/profile_admin/";
            $oldFilePath = $dir . $admProfile;

            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        } else {
            $_SESSION['error'] = "ลบข้อมูลไม่สำเร็จ";
            header($locationError);
            exit;
        }
    } else {
        $_SESSION['error'] = "ไม่พบรหัสพนักงานนี้";
        header($locationSuccess);
        exit;
    }

    if (empty($_SESSION["error"])) {
        $_SESSION['success'] = "ลบข้อมูลผู้ดูแลระบบสำเร็จ";
        header($locationSuccess);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
