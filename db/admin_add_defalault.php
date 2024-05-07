<?php


try {
    // ตรวจสอบว่ามี Admin หรือไม่
    $sql = "SELECT adm_id
            FROM ot_admin";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $check = $stmt->fetch();

    // ถ้าไม่มีให้เพิ่ม Admin
    if (!$check) {
        $admId = 1;
        $admFname = "อดิศักดิ์";
        $admLname = "คงสุข";
        $admUsername = "Admin1";
        $admPassword = "Admin1";
        $admEmail = "Admin.General@gmail.com";

        try {
            // Hash รหัสผ่าน $admPassword
            $hashPassword = password_hash($admPassword, PASSWORD_DEFAULT);

            // Folder เก็บไฟล์
            $dir = "uploads/profile_admin/";
            $fileDefault = "uploads/profile_admin/default.png";

            // ตรวจสอบไฟล์
            if (!file_exists($fileDefault)) {
                $_SESSION["error"] = "ไม่พบไฟล์ default.png";
                header("Location:index.php");
                exit();
            }

            // ไฟล์ default -> สุ่มชื่อ -> นำไปเก็บที่ $pathNewProfile
            $newProfile = uniqid('profile_', true) . ".png";
            $pathNewProfile = $dir . $newProfile;

            // คัดลอกไฟล์
            if (copy($fileDefault, $pathNewProfile)) {
                // เพิ่มข้อมูลในฐานข้อมูล
                $sql = "INSERT INTO ot_admin (adm_id,adm_profile, adm_fname, adm_lname, adm_username, adm_password, adm_email)
                                VALUES (:adm_id,:adm_profile, :adm_fname, :adm_lname, :adm_username, :adm_password, :adm_email)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":adm_id", $admId);
                $stmt->bindParam(":adm_profile", $newProfile);
                $stmt->bindParam(":adm_fname", $admFname);
                $stmt->bindParam(":adm_lname", $admLname);
                $stmt->bindParam(":adm_username", $admUsername);
                $stmt->bindParam(":adm_password", $hashPassword);
                $stmt->bindParam(":adm_email", $admEmail);
                $stmt->execute();
            } else {
                $_SESSION["error"] = "คัดลอกรูปภาพไม่สำเร็จ";
                header("Location:index.php");
                exit();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
    return false;
}
