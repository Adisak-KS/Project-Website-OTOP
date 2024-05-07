<?php
// ตรวจสอบสิทธิ์ Admin
if (!isset($_SESSION['admin_id'])) {
    $_SESSION["error"] = "กรุณาเข้าสู่ระบบก่อนใช้งาน";
    header("location:login_form.php");
    exit;
}
