<?php
require_once("../db/connect.php");

// ตรวจสอบว่ามีการส่งค่า delete มาหรือไม่
if (isset($_POST['mem_id'])) {
    // ตรวจสอบค่าที่ส่งเข้ามาเพื่อป้องกัน SQL Injection
    $memId = filter_input(INPUT_POST, 'mem_id', FILTER_VALIDATE_INT);
    $memProfile = $_POST['mem_profile'];

    $locationSuccess = "refresh:1; url=member_show.php";
    $locationError = "refresh:1; url=member_del_form.php";

    // พบ Memer Id
    if ($memId) {

        // เตรียมคำสั่ง SQL และทำการลบข้อมูล
        $sql = "DELETE FROM ot_member 
                WHERE mem_id = :mem_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mem_id', $memId);
        $stmt->execute();

        // ตรวจสอบว่าลบข้อมูลสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {

            // ลบไฟล์เดิม (ถ้ามี)
            $dir = "../uploads/profile_member/";
            $oldFilePath = $dir . $memProfile;
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
        header($locationError);
        exit;
    }

    if (empty($_SESSION["error"])) {
        $_SESSION['success'] = "ลบข้อมูลสมาชิกสำเร็จ";
        header($locationSuccess);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
