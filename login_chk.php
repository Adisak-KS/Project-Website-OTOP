<?php

require_once("db/connect.php"); // เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล


if (isset($_POST["btn-login"])) {
    $memUsername = $_POST["mem_username"];
    $memPassword = $_POST["mem_password"];

    // ค้นหาข้อมูล Member จาก Database
    $sql = "SELECT mem_id, mem_username, mem_email, mem_password 
            FROM ot_member 
            WHERE mem_username = :mem_username OR mem_email = :mem_email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":mem_username", $memUsername);
    $stmt->bindParam(":mem_email", $memUsername); // ใช้ email เป็นพารามิเตอร์
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // ตรวจสอบว่ามีผู้ใช้งานนี้ในระบบหรือไม่
    if ($result) {

        // ตรวจสอบรหัสผ่าน
        if (password_verify($memPassword, $result['mem_password'])) {

            // เก็บ session สำหรับผู้ใช้ที่เข้าสู่ระบบ
            $_SESSION['mem_id'] = $result['mem_id'];
            $_SESSION['mem_username'] = $result['mem_username'];
            $_SESSION['success'] = "เข้าสู่ระบบโดยผู้ใช้ " . $result['mem_username'] . " สำเร็จ";

            // ส่งผู้ใช้ไปยังหน้าหลักหลังจากเข้าสู่ระบบสำเร็จ
            header("Location: index.php");

        } else {
            // กรณีรหัสผ่านไม่ถูกต้อง
            $_SESSION["error"] = "ชื่อผู้ใช้หรืออีเมลไม่ถูกต้อง";
            header("Location: login_form.php");
            exit();
        }
    } else {
        // กรณีไม่พบผู้ใช้ในระบบ
        $_SESSION["error"] = "ชื่อผู้ใช้หรืออีเมลไม่ถูกต้อง";
        header("Location: login_form.php");
        exit();
    }
} else {
    // กลับหน้าหลังของ User ทั่วไป
    require_once("includes/permission.php");
}
