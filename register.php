<?php
require_once("db/connect.php");


if (isset($_POST["btn-register"])) {
    $memFname = $_POST["mem_fname"];
    $memLname = $_POST["mem_lname"];
    $memUsername = $_POST["mem_username"];
    $memPassword = $_POST["mem_password"];
    $memEmail = $_POST["mem_email"];

    $location = "Location: register_form.php";

    // ตรวจสอบ Username และ Email ซ้ำ
    $stmt = $conn->prepare("SELECT mem_username, mem_email FROM ot_member
                            WHERE mem_username = :mem_username OR mem_email = :mem_email
                            LIMIT 1 ");
    $stmt->bindParam(":mem_username", $memUsername);
    $stmt->bindParam(":mem_email", $memEmail);
    $stmt->execute();
    $result_check = $stmt->fetch(PDO::FETCH_ASSOC);

    // ผลการตรวจสอบ Username และ Email
    if ($result_check !== false) {
        $_SESSION["error"] = "ชื่อผู้ใช้หรืออีเมลนี้ไม่สามารถใช้ได้";
        header($location);
        exit();
    } else {
        try {
            // Hash รหัสผ่าน  $admPassword
            $hashPassword = password_hash($memPassword, PASSWORD_DEFAULT);

            // Folder เก็บไฟล์
            $dir = "uploads/profile_member/";
            $fileDefault = "uploads/profile_member/default.png";

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

                $_SESSION["success"] = "สมัครสมาชิกสำเร็จ";
                header("Location: login_form.php");
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
}else{
    header("Location: index.php");
    exit();
}
