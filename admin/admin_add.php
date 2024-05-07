<?php
require_once("../db/connect.php");

if (isset($_POST["btn-add"])) {
    $admFname = $_POST["adm_fname"];
    $admLname = $_POST["adm_lname"];
    $admUsername = $_POST["adm_username"];
    $admPassword = $_POST["adm_password"];
    $admEmail = $_POST["adm_email"];

    $location = "Location: admin_show.php";

    // ตรวจสอบ Username และ Email ซ้ำ
    $sql = "SELECT adm_username, adm_email 
            FROM ot_admin 
            WHERE adm_username = :adm_username OR adm_email = :adm_email
            LIMIT 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":adm_username", $admUsername);
    $stmt->bindParam(":adm_email", $admEmail);
    $stmt->execute();
    $check = $stmt->fetch();

    // พบ Username และ Email ซ้ำ
    if ($check) {
        $_SESSION["error"] = "ชื่อผู้ใช้หรืออีเมลนี้ไม่สามารถใช้ได้";
        header($location);
        exit();
    } else {

        // ไม่พบ Username และ Email ซ้ำ
        try {
            // Hash รหัสผ่าน $admPassword
            $hashPassword = password_hash($admPassword, PASSWORD_DEFAULT);

            // Folder เก็บไฟล์
            $dir = "../uploads/profile_admin/";
            $fileDefault = "../uploads/profile_admin/default.png";

            // ตรวจสอบไฟล์
            if (!file_exists($fileDefault)) {
                $_SESSION["error"] = "ไม่พบไฟล์ default.png";
                header($location);
                exit();
            }

            // ไฟล์ default -> สุ่มชื่อ -> นำไปเก็บที่ $pathNewProfile
            $newProfile = uniqid('profile_', true) . ".png";
            $pathNewProfile = $dir . $newProfile;

            // คัดลอกไฟล์
            if (copy($fileDefault, $pathNewProfile)) {
                // เพิ่มข้อมูลในฐานข้อมูล
                $sql = "INSERT INTO ot_admin (adm_profile, adm_fname, adm_lname, adm_username, adm_password, adm_email)
                        VALUES (:adm_profile, :adm_fname, :adm_lname, :adm_username, :adm_password, :adm_email)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":adm_profile", $newProfile);
                $stmt->bindParam(":adm_fname", $admFname);
                $stmt->bindParam(":adm_lname", $admLname);
                $stmt->bindParam(":adm_username", $admUsername);
                $stmt->bindParam(":adm_password", $hashPassword);
                $stmt->bindParam(":adm_email", $admEmail);
                $stmt->execute();
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

    if (empty($_SESSION["error"])) {
        $_SESSION["success"] = "เพิ่มข้อมูลผู้ดูแลระบบสำเร็จ";
        header($location);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
