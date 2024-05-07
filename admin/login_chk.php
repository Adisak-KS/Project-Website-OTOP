<?php

require_once("../db/connect.php"); // เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล

if (isset($_POST["btn-login"])) {
    $admUsername = $_POST["adm_username"];
    $admPassword = $_POST["adm_password"];

    $locationSuccess = "Location: index.php";
    $locationError = "Location: login_form.php";


    // ค้นหาข้อมูลผู้ดูแลระบบจากฐานข้อมูล
    $sql = "SELECT adm_id, adm_username, adm_email, adm_password 
            FROM ot_admin 
            WHERE adm_username = :adm_username OR adm_email = :adm_email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":adm_username", $admUsername);
    $stmt->bindParam(":adm_email", $admUsername);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    // ตรวจสอบว่ามีผู้ใช้งานนี้ในระบบหรือไม่
    if ($result) {

        // ตรวจสอบรหัสผ่าน
        if (password_verify($admPassword, $result['adm_password'])) {

            // เก็บ session สำหรับผู้ใช้ที่เข้าสู่ระบบ
            $_SESSION['admin_id'] = $result['adm_id'];
            $_SESSION['admin_username'] = $result['adm_username'];
            $_SESSION['success'] = "เข้าสู่ระบบโดยผู้ใช้ " . $result['adm_username'] . " สำเร็จ";

            // เข้าสู่ระบบสำเร็จ
            header($locationSuccess);
            exit();
            
        } else {

            // กรณีรหัสผ่านไม่ถูกต้อง
            $_SESSION["error"] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
            header($locationError);
            exit();
        }
    } else {

        // กรณีไม่พบผู้ใช้ในระบบ
        $_SESSION["error"] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        header($locationError);
        exit();
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
