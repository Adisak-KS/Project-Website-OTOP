<?php
require_once("../db/connect.php");


if (isset($_POST["btn-add"])) {
    $memFname = $_POST["mem_fname"];
    $memLname = $_POST["mem_lname"];
    $memUsername = $_POST["mem_username"];
    $memPassword = $_POST["mem_password"];
    $memEmail = $_POST["mem_email"];

    $location = "Location: member_show.php";


    // ตรวจสอบ Username และ Email ซ้ำ
    $sql = "SELECT mem_username, mem_email 
            FROM ot_member
            WHERE mem_username = :mem_username OR mem_email = :mem_email
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":mem_username", $memUsername);
    $stmt->bindParam(":mem_email", $memEmail);
    $stmt->execute();
    $check = $stmt->fetch();


    // พบ Username และ Email
    if ($check) {
        $_SESSION["error"] = "ชื่อผู้ใช้หรืออีเมลนี้ไม่สามารถใช้ได้";
        header($location);
        exit();
    } else {

        try {
            // Hash รหัสผ่าน  $memPassword
            $hashPassword = password_hash($memPassword, PASSWORD_DEFAULT);

            // Folder เก็บไฟล์
            $dir = "../uploads/profile_member/";
            $fileDefault = "../uploads/profile_member/default.png";

            // ตรวจสอบไฟล์
            if (!file_exists($fileDefault)) {
                $_SESSION["error"] = "ไม่พบไฟล์ default.png";
                header($location);
                exit();
            }

            // ไฟล์ defaluft -> สุ่มชื่อ -> นำไปเก็บที่ $pathNewProfile
            $nameFileDefault = "default.png";
            $newProfile = uniqid('profile_', true) . ".png"; //นำไปใช้
            $pathNewProfile = $dir . $newProfile;


            // คัดลอกไฟล์
            if (copy($fileDefault, $pathNewProfile)) {

                // เพิ่มข้อมูล Database
                $sql = "INSERT INTO ot_member (mem_profile, mem_fname, mem_lname, mem_username, mem_password, mem_email)
                        VALUES (:mem_profile, :mem_fname, :mem_lname, :mem_username, :mem_password, :mem_email)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":mem_profile", $newProfile);
                $stmt->bindParam(":mem_fname", $memFname);
                $stmt->bindParam(":mem_lname", $memLname);
                $stmt->bindParam(":mem_username", $memUsername);
                $stmt->bindParam(":mem_password", $hashPassword);
                $stmt->bindParam(":mem_email", $memEmail);
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
        $_SESSION["success"] = "เพิ่มข้อมูลสมาชิกสำเร็จ";
        header($location);
    }
} else {
    // กลับหน้า index ของ User ทั่วไป
    require_once("includes/no_permission.php");
}
